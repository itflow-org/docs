<?php
/*
 * ITFlow Docs - turns a page's Markdown into HTML.
 *
 * Just the Markdown the docs use, written here so there is nothing to install
 * and nothing that can change under us:
 *
 *   # Headings (## and ### make the "On this page" list)   ## Heading {#own-id}
 *   Paragraphs, **bold**, *italic*, `code`, [links](/billing/invoices#anchor)
 *   - bullet lists and 1. numbered lists (numbered ones show as steps), nested by indenting
 *   | tables | with | a header row |
 *   ```code blocks```
 *   ![Alt text](invoice-page.webp "Caption")   on a line of its own: a screenshot that zooms
 *   > [!TIP] / > [!NOTE] / > [!WARNING]           a coloured box
 *   <kbd>Ctrl</kbd>                               a key to press
 *   **Admin > Settings > Invoice**                bold menu paths get arrows
 *
 * Everything else is shown as typed, so a page can't break the site.
 */

defined('ITFLOW_DOCS') || exit;

class DocsMarkdown
{
    /** Turns a doc path such as /billing/invoices#x into a link for where the page is shown. */
    private $linkFor;
    /** Turns a screenshot's file name into its address. */
    private $imageFor;

    private $ids = [];
    public $toc = [];

    public function __construct(callable $linkFor, callable $imageFor)
    {
        $this->linkFor = $linkFor;
        $this->imageFor = $imageFor;
    }

    /** Front matter (title: ..., description: ...) and the Markdown after it. */
    public static function split($text)
    {
        $meta = [];
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        if (preg_match('/^---\n(.*?)\n---\n/s', $text, $m)) {
            foreach (explode("\n", $m[1]) as $line) {
                if (preg_match('/^([a-z_]+):\s*(.*)$/', $line, $kv)) {
                    $meta[$kv[1]] = trim($kv[2], " \t\"'");
                }
            }
            $text = substr($text, strlen($m[0]));
        }
        return [$meta, $text];
    }

    public function render($markdown)
    {
        $this->ids = [];
        $this->toc = [];
        return $this->blocks(explode("\n", $markdown));
    }

    /* ------------------------------------------------------------ Blocks */

    private function blocks(array $lines)
    {
        $html = '';
        $count = count($lines);
        $i = 0;

        while ($i < $count) {
            $line = $lines[$i];

            if (trim($line) === '') {
                $i++;
                continue;
            }

            // ``` code ```
            if (preg_match('/^\s*```\s*([a-z0-9-]*)\s*$/i', $line, $m)) {
                $code = [];
                $i++;
                while ($i < $count && !preg_match('/^\s*```\s*$/', $lines[$i])) {
                    $code[] = $lines[$i];
                    $i++;
                }
                $i++;
                $html .= '<pre class="code"' . ($m[1] ? ' data-lang="' . self::e($m[1]) . '"' : '') . '><code>' . self::e(implode("\n", $code)) . '</code></pre>' . "\n";
                continue;
            }

            // # Heading
            if (preg_match('/^(#{1,4})\s+(.+?)\s*(?:\{#([a-z0-9-]+)\})?\s*$/', $line, $m)) {
                $html .= $this->heading(strlen($m[1]), $m[2], $m[3] ?? '');
                $i++;
                continue;
            }

            // --- rule
            if (preg_match('/^\s*(-{3,}|\*{3,})\s*$/', $line)) {
                $html .= "<hr>\n";
                $i++;
                continue;
            }

            // > quote, or > [!TIP] box
            if (preg_match('/^\s*>/', $line)) {
                $quote = [];
                while ($i < $count && preg_match('/^\s*>\s?(.*)$/', $lines[$i], $m)) {
                    $quote[] = $m[1];
                    $i++;
                }
                $html .= $this->quote($quote);
                continue;
            }

            // | table |
            if (preg_match('/^\s*\|/', $line) && isset($lines[$i + 1]) && preg_match('/^\s*\|?\s*:?-{3,}/', $lines[$i + 1])) {
                $rows = [];
                while ($i < $count && preg_match('/^\s*\|/', $lines[$i])) {
                    $rows[] = $lines[$i];
                    $i++;
                }
                $html .= $this->table($rows);
                continue;
            }

            // ![Alt](shot.webp "Caption") on its own line
            if (preg_match('/^\s*!\[([^\]]*)\]\(([^)\s]+)(?:\s+"([^"]*)")?\)\s*$/', $line, $m)) {
                $html .= $this->figure($m[1], $m[2], $m[3] ?? '');
                $i++;
                continue;
            }

            // - lists and 1. lists
            if (preg_match('/^(\s*)([-*+]|\d+[.)])\s+/', $line, $m)) {
                $base = strlen($m[1]);
                // A bulleted list and a numbered one next to each other are two lists
                $kind = ctype_digit($m[2][0]) ? 'ol' : 'ul';
                $same = function ($marker, $indent) use ($base, $kind) {
                    return $indent > $base || (ctype_digit($marker[0]) ? 'ol' : 'ul') === $kind;
                };
                $block = [];
                while ($i < $count) {
                    $l = $lines[$i];
                    if (trim($l) === '') {
                        // A blank line ends the list unless the list carries on after it
                        $next = $i + 1 < $count ? $lines[$i + 1] : '';
                        if (preg_match('/^(\s*)([-*+]|\d+[.)])\s+/', $next, $n) && strlen($n[1]) >= $base && $same($n[2], strlen($n[1]))) {
                            $block[] = '';
                            $i++;
                            continue;
                        }
                        if ($next !== '' && strlen($next) - strlen(ltrim($next)) > $base) {
                            $block[] = '';
                            $i++;
                            continue;
                        }
                        break;
                    }
                    $indent = strlen($l) - strlen(ltrim($l));
                    if ($indent <= $base && !preg_match('/^\s*([-*+]|\d+[.)])\s+/', $l) && !empty($block)) {
                        break;
                    }
                    if (!empty($block) && preg_match('/^(\s*)([-*+]|\d+[.)])\s+/', $l, $n) && !$same($n[2], strlen($n[1]))) {
                        break;
                    }
                    $block[] = $l;
                    $i++;
                }
                $html .= $this->listBlock($block, $base);
                continue;
            }

            // Paragraph: lines up to a blank line or the start of something else
            $para = [];
            while ($i < $count && trim($lines[$i]) !== '' && !$this->startsBlock($lines[$i], $lines[$i + 1] ?? '')) {
                $para[] = trim($lines[$i]);
                $i++;
            }
            if (empty($para)) {
                // A line that only looked like the start of a block
                $para[] = trim($lines[$i]);
                $i++;
            }
            $html .= '<p>' . $this->inline(implode("\n", $para)) . "</p>\n";
        }

        return $html;
    }

    private function startsBlock($line, $next)
    {
        return preg_match('/^\s*(```|#{1,4}\s|>|([-*+]|\d+[.)])\s+)/', $line)
            || preg_match('/^\s*!\[[^\]]*\]\([^)]+\)\s*$/', $line)
            || (preg_match('/^\s*\|/', $line) && preg_match('/^\s*\|?\s*:?-{3,}/', $next));
    }

    private function heading($level, $text, $id)
    {
        $plain = trim(strip_tags($this->inline($text)));
        $id = $id !== '' ? $id : self::slug(html_entity_decode($plain, ENT_QUOTES, 'UTF-8'));
        $base = $id;
        $n = 2;
        while (isset($this->ids[$id])) {
            $id = $base . '-' . $n++;
        }
        $this->ids[$id] = true;

        if ($level === 2 || $level === 3) {
            $this->toc[] = ['level' => $level, 'id' => $id, 'text' => html_entity_decode($plain, ENT_QUOTES, 'UTF-8')];
        }
        if ($level === 1) {
            return '<h1>' . $this->inline($text) . "</h1>\n";
        }
        return '<h' . $level . ' id="' . self::e($id) . '">' . $this->inline($text)
            . '<a class="anchor" href="#' . self::e($id) . '" aria-label="Link to this section"><i class="fas fa-link" aria-hidden="true"></i></a></h' . $level . ">\n";
    }

    private function quote(array $lines)
    {
        $kinds = [
            'NOTE' => ['note', 'circle-info', 'Note'],
            'TIP' => ['tip', 'lightbulb', 'Tip'],
            'WARNING' => ['warning', 'triangle-exclamation', 'Watch out'],
            'ACCESS' => ['access', 'user-shield', 'Who can do this'],
        ];
        if (preg_match('/^\s*\[!([A-Z]+)\]\s*(.*)$/', $lines[0] ?? '', $m) && isset($kinds[$m[1]])) {
            [$class, $icon, $label] = $kinds[$m[1]];
            if (trim($m[2]) !== '') {
                $label = trim($m[2]);
            }
            $body = $this->blocks(array_slice($lines, 1));
            return '<div class="callout callout-' . $class . '"><div class="callout-title"><i class="fas fa-' . $icon . '" aria-hidden="true"></i>' . $this->inline($label) . '</div>' . $body . "</div>\n";
        }
        return '<blockquote>' . $this->blocks($lines) . "</blockquote>\n";
    }

    private function table(array $rows)
    {
        $cells = function ($row) {
            $row = trim($row);
            $row = preg_replace('/^\||\|$/', '', $row);
            return array_map('trim', preg_split('/(?<!\\\\)\|/', $row));
        };
        $head = $cells($rows[0]);
        $align = array_map(function ($c) {
            $c = trim($c);
            if (substr($c, -1) === ':' && $c[0] === ':') {
                return 'center';
            }
            return substr($c, -1) === ':' ? 'right' : '';
        }, $cells($rows[1]));

        $html = '<div class="table-wrap"><table><thead><tr>';
        foreach ($head as $n => $c) {
            $html .= '<th' . (!empty($align[$n]) ? ' style="text-align:' . $align[$n] . '"' : '') . '>' . $this->inline(str_replace('\|', '|', $c)) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach (array_slice($rows, 2) as $row) {
            $html .= '<tr>';
            foreach ($cells($row) as $n => $c) {
                $html .= '<td' . (!empty($align[$n]) ? ' style="text-align:' . $align[$n] . '"' : '') . '>' . $this->inline(str_replace('\|', '|', $c)) . '</td>';
            }
            $html .= '</tr>';
        }
        return $html . "</tbody></table></div>\n";
    }

    private function figure($alt, $src, $caption)
    {
        $url = call_user_func($this->imageFor, $src);
        $size = '';
        $file = call_user_func($this->imageFor, $src, true);
        if ($file && is_file($file) && ($dims = @getimagesize($file))) {
            // Shots are taken at 2x, so they show at half their pixel size - a window at the size it really is
            $size = ' width="' . (int) round($dims[0] / 2) . '" height="' . (int) round($dims[1] / 2) . '"';
        }
        return '<figure class="shot"><a class="shot-link" href="' . self::e($url) . '" data-zoom>'
            . '<img src="' . self::e($url) . '" alt="' . self::e($alt) . '"' . $size . ' loading="lazy" decoding="async"></a>'
            . ($caption !== '' ? '<figcaption>' . $this->inline($caption) . '</figcaption>' : '')
            . "</figure>\n";
    }

    private function listBlock(array $lines, $base)
    {
        // Split into items at each marker on the base indent
        $items = [];
        $ordered = null;
        $start = 1;
        foreach ($lines as $line) {
            if (preg_match('/^(\s*)([-*+]|(\d+)[.)])\s+(.*)$/', $line, $m) && strlen($m[1]) <= $base) {
                if ($ordered === null) {
                    $ordered = isset($m[3]) && $m[3] !== '';
                    $start = $ordered ? (int) $m[3] : 1;
                }
                $items[] = [$m[4]];
                continue;
            }
            if (!empty($items)) {
                $items[count($items) - 1][] = $line;
            }
        }

        $html = $ordered ? '<ol class="steps"' . ($start !== 1 ? ' start="' . $start . '" style="counter-reset: step ' . ($start - 1) . '"' : '') . '>' : '<ul>';
        foreach ($items as $item) {
            // Lines after the first are dedented by the item's own indent
            $rest = array_slice($item, 1);
            $indents = [];
            foreach ($rest as $l) {
                if (trim($l) !== '') {
                    $indents[] = strlen($l) - strlen(ltrim($l));
                }
            }
            $cut = $indents ? min($indents) : 0;
            $body = [$item[0]];
            foreach ($rest as $l) {
                $body[] = substr($l, min($cut, strlen($l) - strlen(ltrim($l))));
            }
            $inner = $this->blocks($body);
            // A short item is just its text, without a paragraph around it
            $inner = preg_replace('/^<p>(.*?)<\/p>\n(?!<p>)/s', '$1', $inner, 1);
            $html .= '<li>' . trim($inner) . '</li>';
        }
        return $html . ($ordered ? '</ol>' : '</ul>') . "\n";
    }

    /* ------------------------------------------------------------ Inline */

    public function inline($text)
    {
        $keep = [];
        $hold = function ($html) use (&$keep) {
            $keep[] = $html;
            return "\x01" . (count($keep) - 1) . "\x02";
        };

        // `code` first, so nothing inside it changes
        $text = preg_replace_callback('/`([^`]+)`/', function ($m) use ($hold) {
            return $hold('<code>' . self::e($m[1]) . '</code>');
        }, $text);

        // <kbd>keys</kbd>
        $text = preg_replace_callback('/<kbd>([^<]{1,30})<\/kbd>/', function ($m) use ($hold) {
            return $hold('<kbd>' . self::e($m[1]) . '</kbd>');
        }, $text);

        // ![alt](src) inside a line: a small inline picture
        $text = preg_replace_callback('/!\[([^\]]*)\]\(([^)\s]+)\)/', function ($m) use ($hold) {
            return $hold('<img class="inline-img" src="' . self::e(call_user_func($this->imageFor, $m[2])) . '" alt="' . self::e($m[1]) . '">');
        }, $text);

        // [text](link)
        $text = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)\)/', function ($m) use ($hold) {
            $href = $m[2];
            $external = preg_match('#^(https?:)?//#', $href);
            if (!$external && ($href[0] === '/' || $href[0] === '#')) {
                $href = call_user_func($this->linkFor, $href);
            }
            $label = $this->inline($m[1]);
            return $hold('<a href="' . self::e($href) . '"' . ($external ? ' target="_blank" rel="noopener"' : '') . '>' . $label
                . ($external ? '<i class="fas fa-arrow-up-right-from-square ext" aria-hidden="true"></i>' : '') . '</a>');
        }, $text);

        $text = self::e($text);

        // **bold**, with menu paths (Admin > Settings) shown with arrows
        $text = preg_replace_callback('/\*\*(.+?)\*\*/s', function ($m) {
            $inner = str_replace(' &gt; ', '<span class="sep" aria-hidden="true"><i class="fas fa-chevron-right"></i></span><span class="visually-hidden"> &gt; </span>', $m[1]);
            return '<strong>' . $inner . '</strong>';
        }, $text);
        // *italic*
        $text = preg_replace('/(?<![\w*])\*(?!\s)(.+?)(?<!\s)\*(?![\w*])/s', '<em>$1</em>', $text);
        // A line ending in two spaces or a backslash is a line break
        $text = preg_replace('/( {2,}|\\\\)\n/', "<br>\n", $text);

        return preg_replace_callback('/\x01(\d+)\x02/', function ($m) use ($keep) {
            return $keep[(int) $m[1]];
        }, $text);
    }

    /* ------------------------------------------------------------ Helpers */

    public static function e($s)
    {
        return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function slug($text)
    {
        $text = strtolower(trim($text));
        // "The invoice's page" is the-invoices-page, not the-invoice-s-page
        $text = str_replace(["'", "\u{2019}"], '', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-') ?: 'section';
    }
}
