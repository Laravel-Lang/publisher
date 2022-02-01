require('dotenv').config();

const hostname = 'publisher.laravel-lang.com';

module.exports = {
    lang: 'en-US',
    title: 'Laravel Lang Publisher',
    description: 'Publisher lang files for the Laravel Framework, Jetstream, Fortify, Cashier, Spark, Nova and UI from Laravel-Lang/lang.',

    head: [
        ['link', { rel: 'icon', href: '/images/logo.svg' }],
        ['meta', { name: 'twitter:image', content: 'https://publisher.laravel-lang.com/images/social-logo.png' }]
    ],

    theme: '@vuepress/theme-default',
    themeConfig: {
        hostname,
        base: '/',

        logo: '/images/logo.svg',

        repo: 'https://github.com/Laravel-Lang/publisher',
        repoLabel: 'GitHub',
        docsRepo: 'https://github.com/Laravel-Lang/publisher',
        docsBranch: 'main',
        docsDir: 'docs',

        editLink: true,

        navbar: [
            { text: 'Guide', link: '/using/index.md' },

            {
                text: 'Plugins',
                children: [
                    '/plugins/installation.md',
                    '/plugins/local.md',
                    '/plugins/community.md'
                ]
            },

            { text: 'Changelog', link: '/changelog.md' }
        ],

        sidebarDepth: 1,

        sidebar: [
            {
                text: 'Prologue',
                collapsible: true,
                children: [
                    '/changelog.md',
                    '/installation/upgrade/index.md'
                ]
            },

            {
                text: 'Getting Started',
                collapsible: true,
                children: [
                    {
                        text: 'Introduction',
                        link: '/'
                    },

                    {
                        text: 'Installation',
                        link: '/installation/',
                        children: [
                            '/installation/compatibility.md',
                            '/installation/laravel-framework.md',
                            '/installation/lumen-framework.md'
                        ]
                    }
                ]
            },
            {
                text: 'Guide',
                collapsible: true,
                children: [
                    {
                        text: 'Basic Usage',
                        children: [
                            '/using/index.md',
                            '/using/add.md',
                            '/using/update.md',
                            '/using/reset.md',
                            '/using/remove.md'
                        ]
                    },

                    {
                        text: 'Features',
                        children: [
                            '/features/alignment.md',
                            '/features/facades.md'
                        ]
                    },

                    {
                        text: 'Plugins',
                        children: [
                            '/plugins/installation.md',
                            '/plugins/local.md',
                            '/plugins/community.md'
                        ]
                    }
                ]
            },
            { text: 'License', link: '/license.md' }
        ]
    },

    plugins: [
        [
            'seo',
            {
                description: $page => $page.frontmatter.description,
                type: _ => 'website',
                image: (_, $site) => $site.domain + '/images/social-logo.png'
            }
        ],
        [
            '@vuepress/docsearch',
            {
                appId: process.env.VITE_APP_ALGOLIA_APP_ID,
                apiKey: process.env.VITE_APP_ALGOLIA_API_KEY,
                indexName: process.env.VITE_APP_ALGOLIA_INDEX_NAME
            }
        ]
    ]
};
