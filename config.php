<?php
/*
 * ITFlow Docs - settings.
 *
 * Change what you need in config.local.php (copy config.local.example.php),
 * so this file can be updated without losing your changes.
 */

defined('ITFLOW_DOCS') || exit;

$docs = [
    // The name in the top bar and the browser tab
    'name' => 'ITFlow Docs',
    'description' => 'How to install and use ITFlow: the service desk, client documentation, billing, finance, the client portal and administration, step by step with screenshots.',

    // Where the docs live, without a trailing slash. Used for links shared elsewhere.
    'url' => 'https://docs.itflow.org',

    // Set this when the docs are in a folder rather than at the top of the site, such as '/docs'
    'base' => '',

    // The version of ITFlow these pages describe
    'version' => '26.11',

    // Links in the top bar and the footer
    'website_url' => 'https://itflow.org',
    'demo_url' => 'https://demo.itflow.org',
    'forum_url' => 'https://forum.itflow.org',
    'github_url' => 'https://github.com/itflow-org/itflow',

    // "Suggest a change" under each page. {path} becomes the page's file, such as billing/invoices.md.
    // Leave empty to hide it.
    'edit_url' => '',
];

/*
 * Old addresses that should land on a page here, such as links in ITFlow
 * itself (Admin > Update links to /backups). Each one is sent on to the page,
 * or to an address elsewhere when it starts with http.
 */
$redirects = [
    // Linked from ITFlow itself
    'installation' => 'install/requirements',
    'config_php' => 'install/config-php',
    'gathering_logs' => 'install/troubleshooting#error-logs',
    'backups' => 'admin/maintenance#backup',
    'telemetry' => 'admin/settings#telemetry',
    'ticket_email_parse' => 'admin/tickets#email-to-ticket',
    // The old wiki's pages, which people may have bookmarked
    'installation_script' => 'install/install-script',
    'installation_apt' => 'install/manual',
    'installation_hestiacp' => 'install/manual#other-ways',
    'installation_docker' => 'install/manual#other-ways',
    'updates' => 'install/updating',
    'cron' => 'admin/maintenance#cron',
    'email_config' => 'admin/mail',
    'aad_sso' => 'admin/client-portal#signing-in-with-microsoft-365',
    'ai' => 'admin/ai',
    'roles' => 'admin/roles',
    'slas' => 'admin/tickets#slas',
    'logs' => 'admin/logs',
    'api' => 'api/overview',
    'tags' => 'admin/categories-and-tags',
    'assets' => 'documentation/assets',
    'certificates' => 'documentation/certificates',
    'clients' => 'clients/clients',
    'contacts' => 'clients/contacts',
    'documents' => 'documentation/files-and-documents',
    'files' => 'documentation/files-and-documents',
    'domains' => 'documentation/domains',
    'licenses' => 'documentation/licenses',
    'networks' => 'documentation/networks',
    'passwords' => 'documentation/credentials',
    'services' => 'documentation/services',
    'shared_links' => 'documentation/shared-links',
    'tickets' => 'service-desk/tickets',
    'vendors' => 'clients/vendors',
    'expenses' => 'finance/expenses',
    'invoices' => 'billing/invoices',
    'payments' => 'billing/payments',
    'products' => 'billing/products',
    'quotes' => 'billing/quotes',
    'recurring' => 'billing/recurring-invoices',
    'trips' => 'billing/trips',
    'contribute' => 'https://github.com/itflow-org/itflow/blob/master/CONTRIBUTING.md',
    // Other old addresses
    'backup' => 'admin/maintenance#backup',
    'email' => 'admin/mail',
    'users' => 'admin/users',
    'client_portal' => 'portal/overview',
    'stripe' => 'admin/payment-providers',
    'taxes' => 'admin/taxes',
    'starter_content' => 'admin/maintenance#starter-content',
];

if (is_file(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
}
