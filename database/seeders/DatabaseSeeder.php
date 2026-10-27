<?php

namespace Database\Seeders;

use App\Models\CurrentlyItem;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\NavigationLink;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedHomepageSections();
        $this->seedNavigation();
        $this->seedSocialLinks();
        $this->seedServices();
        $this->seedSkills();
        $this->seedExperiences();
        $this->seedProjects();
        $this->seedCurrently();
        $this->seedPages();
        $this->seedUsers();
    }

    private function seedSettings(): void
    {
        $settings = [
            // General
            'site_name' => 'B. P. Parajuli',
            'tagline' => 'Laravel Developer & Consultant',
            'footer_note' => 'Building reliable, maintainable Laravel applications.',

            // Branding
            'color_primary' => '#820B5C',
            'color_secondary' => '#1A0262',
            'color_accent' => '#2563EB',

            // Contact
            'contact_email' => 'hello@bpparajuli.com',
            'contact_phone' => '+977 9800 000 000',
            'contact_location' => 'Kathmandu, Nepal',

            // Profile
            'profile_name' => 'B. P. Parajuli',
            'profile_headline' => 'Laravel Developer & Consultant',
            'profile_short_bio' => 'I design and build reliable Laravel applications â€” from architecture and APIs through to deployment and long-term maintenance.',
            'profile_bio' => "<p>I'm a Laravel developer focused on building software that is simple to understand, easy to maintain, and dependable in production. Over the last decade I've worked with startups, agencies and established businesses to turn rough ideas into working products.</p>\n\n<p>My work sits at the intersection of backend engineering and product thinking. I care as much about the architecture behind a feature as I do about whether it actually solves the problem it was built for.</p>\n\n<h2>What I do</h2>\n<ul>\n<li>Design and build Laravel applications and APIs</li>\n<li>Modernise and refactor legacy PHP codebases</li>\n<li>Set up testing, CI/CD and deployment pipelines</li>\n<li>Work directly with founders and product teams</li>\n</ul>\n\n<p>When I'm not writing code, I'm usually reading about software design, mentoring other developers, or exploring new tools in the Laravel ecosystem.</p>",
            'profile_location' => 'Kathmandu, Nepal',
            'profile_availability' => 'Available for freelance & contract work',
            'profile_current_focus' => "<p>Right now I'm focused on building maintainable Laravel applications, improving how teams test their code, and exploring event-driven architecture with Laravel.</p>",
            'profile_image' => $this->image('profile.svg', 'B. P. Parajuli', '#820B5C', '#1A0262', 800, 1000),

            // SEO
            'default_meta_title' => 'B. P. Parajuli â€” Laravel Developer & Consultant',
            'default_meta_description' => 'Laravel developer building reliable web applications, APIs and integrations. Based in Kathmandu, working with clients worldwide.',
        ];

        foreach ($settings as $key => $value) {
            $group = match (true) {
                str_starts_with($key, 'profile_') || $key === 'profile_image' => 'profile',
                str_starts_with($key, 'contact_') => 'contact',
                str_starts_with($key, 'color_') => 'appearance',
                str_starts_with($key, 'default_') => 'seo',
                default => 'general',
            };

            Settings::set($key, $value, $group);
        }
    }

    private function seedHomepageSections(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'name' => 'Hero',
                'eyebrow' => 'Laravel Developer',
                'title' => 'Reliable Laravel applications, shipped with care.',
                'subtitle' => 'I partner with founders and teams to design, build and maintain web applications that are fast, secure and built to last.',
            ],
            [
                'key' => 'about',
                'name' => 'About',
                'eyebrow' => 'About',
                'title' => 'A developer who thinks like an owner',
            ],
            [
                'key' => 'capabilities',
                'name' => 'Capabilities',
                'eyebrow' => 'What I Do',
                'title' => 'Full-stack Laravel development',
                'subtitle' => 'From greenfield products to legacy rescue missions â€” practical development across the entire lifecycle of a web application.',
            ],
            [
                'key' => 'projects',
                'name' => 'Projects',
                'eyebrow' => 'Selected Work',
                'title' => 'Featured projects',
                'subtitle' => 'A few projects that show how I approach problems and deliver working results.',
            ],
            [
                'key' => 'approach',
                'name' => 'Approach',
                'eyebrow' => 'How I Work',
                'title' => 'A repeatable approach to delivery',
                'subtitle' => 'Software is hard when it is fuzzy. I keep projects grounded with a clear process that moves from problem to measurable outcome.',
                'settings' => [
                    'steps' => [
                        ['title' => 'Understand', 'description' => 'Clarify the real problem, the constraints, and who the work is for before writing any code.'],
                        ['title' => 'Structure', 'description' => 'Turn ambiguity into a concrete plan â€” priorities, sequence, and a shared definition of success.'],
                        ['title' => 'Build', 'description' => 'Ship in small, testable increments using the simplest tooling that gets the job done well.'],
                        ['title' => 'Improve', 'description' => 'Measure, learn, and refine. A codebase that keeps improving is one that keeps working.'],
                    ],
                ],
            ],
            [
                'key' => 'skills',
                'name' => 'Skills',
                'eyebrow' => 'Skills',
                'title' => 'What I work with',
                'subtitle' => 'A focused toolkit built through years of hands-on work across backend, frontend and infrastructure.',
            ],
            [
                'key' => 'experience',
                'name' => 'Experience',
                'eyebrow' => 'Experience',
                'title' => 'Where I have worked',
                'subtitle' => 'A decade of building software for startups, agencies and product companies.',
            ],
            [
                'key' => 'currently',
                'name' => 'Currently',
                'eyebrow' => 'Currently',
                'title' => 'What I am working on now',
                'subtitle' => 'A snapshot of what is on my desk right now.',
            ],
            [
                'key' => 'contact_cta',
                'name' => 'Contact CTA',
                'eyebrow' => 'Get in touch',
                'title' => "Let's build something that works.",
                'subtitle' => 'Have a project, a problem, or an idea worth exploring? Start a conversation and let us work through it together.',
            ],
        ];

        foreach ($sections as $index => $section) {
            HomepageSection::query()->updateOrCreate(
                ['key' => $section['key']],
                [
                    'name' => $section['name'],
                    'eyebrow' => $section['eyebrow'],
                    'title' => $section['title'],
                    'subtitle' => $section['subtitle'] ?? null,
                    'settings' => $section['settings'] ?? null,
                    'is_enabled' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }

    private function seedNavigation(): void
    {
        $links = [
            ['group' => 'header', 'label' => 'Home', 'url' => '/', 'sort_order' => 0],
            ['group' => 'header', 'label' => 'About', 'url' => '/about', 'sort_order' => 1],
            ['group' => 'header', 'label' => 'Projects', 'url' => '/projects', 'sort_order' => 2],
            ['group' => 'header', 'label' => 'Services', 'url' => '/services', 'sort_order' => 3],
            ['group' => 'header', 'label' => 'Contact', 'url' => '/contact', 'sort_order' => 4],

            ['group' => 'footer', 'label' => 'About', 'url' => '/about', 'sort_order' => 0],
            ['group' => 'footer', 'label' => 'Projects', 'url' => '/projects', 'sort_order' => 1],
            ['group' => 'footer', 'label' => 'Services', 'url' => '/services', 'sort_order' => 2],
            ['group' => 'footer', 'label' => 'Contact', 'url' => '/contact', 'sort_order' => 3],

            ['group' => 'legal', 'label' => 'Privacy Policy', 'url' => '/privacy-policy', 'sort_order' => 0],
            ['group' => 'legal', 'label' => 'Terms of Service', 'url' => '/terms-of-service', 'sort_order' => 1],
        ];

        foreach ($links as $link) {
            NavigationLink::query()->updateOrCreate(
                ['group' => $link['group'], 'label' => $link['label']],
                [
                    'url' => $link['url'],
                    'target' => '_self',
                    'is_active' => true,
                    'sort_order' => $link['sort_order'],
                ],
            );
        }
    }

    private function seedSocialLinks(): void
    {
        $links = [
            ['platform' => 'github', 'url' => 'https://github.com/bpparajuli', 'sort_order' => 0],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/bpparajuli', 'sort_order' => 1],
            ['platform' => 'x', 'label' => 'X (Twitter)', 'url' => 'https://x.com/bpparajuli', 'sort_order' => 2],
        ];

        foreach ($links as $link) {
            SocialLink::query()->updateOrCreate(
                ['platform' => $link['platform']],
                [
                    'label' => $link['label'] ?? null,
                    'url' => $link['url'],
                    'icon' => null,
                    'is_active' => true,
                    'sort_order' => $link['sort_order'],
                ],
            );
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'title' => 'Custom Web Applications',
                'icon' => 'code',
                'short_description' => 'Bespoke Laravel applications designed around your business, from internal tools to customer-facing products.',
                'full_description' => "<p>I design and build custom web applications with Laravel â€” the kind of software that becomes the backbone of your business. Every project starts with understanding the problem, then moves into architecture, implementation and testing.</p>\n\n<ul>\n<li>Product discovery and scoping</li>\n<li>Architecture and data modelling</li>\n<li>Feature development and testing</li>\n<li>Launch and handover</li>\n</ul>",
            ],
            [
                'title' => 'API Development & Integration',
                'icon' => 'cpu',
                'short_description' => 'Clean, versioned REST and GraphQL APIs that mobile apps, frontends and third parties can rely on.',
                'full_description' => "<p>APIs are the connective tissue of modern software. I build robust, documented and secure APIs that are easy for other teams to consume â€” and integrate with the services your product already depends on.</p>",
            ],
            [
                'title' => 'Laravel Upgrades & Refactoring',
                'icon' => 'cog',
                'short_description' => 'Bringing legacy codebases onto supported versions with tests and confidence â€” not guesswork.',
                'full_description' => "<p>Legacy code doesn't have to be a liability. I upgrade outdated Laravel applications, untangle messy code, and introduce tests so the system becomes safer to change over time.</p>",
            ],
            [
                'title' => 'E-commerce Development',
                'icon' => 'chart',
                'short_description' => 'Online stores and billing systems with payments, inventory, and a smooth checkout experience.',
                'full_description' => "<p>From custom storefronts to subscription billing, I build e-commerce systems that handle payments reliably with Stripe and other providers, keeping the checkout simple and the back office manageable.</p>",
            ],
            [
                'title' => 'System Integration & Automation',
                'icon' => 'lightbulb',
                'short_description' => 'Connecting your tools with queues, webhooks and scheduled jobs that run without manual effort.',
                'full_description' => "<p>Your business runs on many tools. I connect them with background jobs, webhooks and automation so data flows automatically and your team stops copying things by hand.</p>",
            ],
            [
                'title' => 'Maintenance & Support',
                'icon' => 'briefcase',
                'short_description' => 'Ongoing care for production applications â€” monitoring, fixes, and improvements you can plan on.',
                'full_description' => "<p>Software needs looking after. I provide ongoing maintenance, performance improvements and support for Laravel applications, so your product keeps working while you focus on the business.</p>",
            ],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['title' => $service['title']],
                [
                    'short_description' => $service['short_description'],
                    'full_description' => $service['full_description'],
                    'icon' => $service['icon'],
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }

    private function seedSkills(): void
    {
        $categories = [
            [
                'name' => 'Backend & Frameworks',
                'icon' => 'cpu',
                'description' => 'The core of my daily work â€” building reliable, testable server-side systems.',
                'skills' => [
                    ['Laravel', 'Building maintainable applications with the Laravel ecosystem.', 10],
                    ['PHP', 'Modern, type-safe PHP 8 for production systems.', 10],
                    ['MySQL / PostgreSQL', 'Relational data modelling and query optimisation.', 9],
                    ['Redis', 'Caching, queues and real-time data structures.', 7],
                    ['REST APIs', 'Designing clean, versioned and documented APIs.', 9],
                    ['Livewire', 'Reactive UIs without leaving Laravel.', 5],
                    ['Filament', 'Rapid admin panels and internal tooling.', 4],
                ],
            ],
            [
                'name' => 'Frontend',
                'icon' => 'code',
                'description' => 'Enough frontend to ship polished interfaces without a separate team.',
                'skills' => [
                    ['Vue.js', 'Component-driven interfaces for interactive products.', 6],
                    ['Alpine.js', 'Lightweight interactivity for Blade templates.', 5],
                    ['Tailwind CSS', 'Utility-first styling for fast, consistent UIs.', 6],
                    ['Inertia.js', 'Bridging Laravel backends with SPA-like frontends.', 5],
                    ['Blade', 'Laravel\'s templating engine, used on every project.', 10],
                    ['JavaScript / TypeScript', 'Modern JS for the frontend where it matters.', 8],
                ],
            ],
            [
                'name' => 'DevOps & Tooling',
                'icon' => 'cog',
                'description' => 'Shipping and running software reliably in production.',
                'skills' => [
                    ['Docker', 'Reproducible local and production environments.', 6],
                    ['Git & GitHub', 'Version control, code review and collaboration.', 10],
                    ['GitHub Actions', 'Automated testing and deployment pipelines.', 5],
                    ['Nginx', 'Web server configuration and performance tuning.', 7],
                    ['Laravel Forge', 'Server provisioning and zero-downtime deploys.', 6],
                    ['Pest / PHPUnit', 'Confident refactoring through automated tests.', 8],
                    ['Vite', 'Fast asset bundling for the modern Laravel stack.', 4],
                ],
            ],
        ];

        foreach ($categories as $categoryIndex => $category) {
            $model = SkillCategory::query()->updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'icon' => $category['icon'],
                    'is_active' => true,
                    'sort_order' => $categoryIndex,
                ],
            );

            foreach ($category['skills'] as $skillIndex => [$name, $description, $years]) {
                Skill::query()->updateOrCreate(
                    ['skill_category_id' => $model->id, 'name' => $name],
                    [
                        'description' => $description,
                        'years_experience' => $years,
                        'is_featured' => $years >= 7,
                        'is_active' => true,
                        'sort_order' => $skillIndex,
                    ],
                );
            }
        }
    }

    private function seedExperiences(): void
    {
        $experiences = [
            [
                'organization' => 'Acme Digital',
                'position' => 'Senior Laravel Developer',
                'location' => 'Remote',
                'start_date' => '2021-01-01',
                'is_current' => true,
                'organization_url' => 'https://example.com',
                'description' => 'Leading the design and delivery of a multi-tenant SaaS platform serving thousands of businesses.',
                'responsibilities' => [
                    'Architected a modular, multi-tenant Laravel application',
                    'Introduced automated testing and CI/CD, cutting release time in half',
                    'Mentored a team of four developers through weekly pairing sessions',
                ],
                'achievements' => [
                    'Reduced page load times by 60% through query and caching optimisation',
                    'Shipped a payment system handling $2M+ in annual transactions',
                ],
            ],
            [
                'organization' => 'Northwind Labs',
                'position' => 'Full-Stack Developer',
                'location' => 'Kathmandu, Nepal',
                'start_date' => '2018-03-01',
                'end_date' => '2020-12-01',
                'organization_url' => 'https://example.com',
                'description' => 'Built customer-facing web applications and APIs for a range of client projects.',
                'responsibilities' => [
                    'Delivered 15+ projects from discovery through to launch',
                    'Built REST APIs consumed by iOS and Android applications',
                    'Standardised deployment workflows across client environments',
                ],
                'achievements' => [
                    'Delivered a client portal that reduced manual support tickets by 40%',
                ],
            ],
            [
                'organization' => 'Bluebird Studio',
                'position' => 'PHP Developer',
                'location' => 'Kathmandu, Nepal',
                'start_date' => '2016-06-01',
                'end_date' => '2018-02-01',
                'description' => 'Developed and maintained Laravel applications for small businesses and startups.',
                'responsibilities' => [
                    'Built and maintained Laravel applications across multiple domains',
                    'Wrote features end-to-end, from database schema to templates',
                ],
                'achievements' => [
                    'Introduced version control and code review practices to the team',
                ],
            ],
            [
                'organization' => 'Freelance',
                'position' => 'Junior Web Developer',
                'location' => 'Kathmandu, Nepal',
                'start_date' => '2014-01-01',
                'end_date' => '2016-05-01',
                'description' => 'Learned the craft building websites and small applications for local clients.',
                'responsibilities' => [
                    'Built brochure sites and simple web apps with PHP and MySQL',
                    'Supported clients with hosting, domains and basic maintenance',
                ],
                'achievements' => [],
            ],
        ];

        foreach ($experiences as $index => $experience) {
            Experience::query()->updateOrCreate(
                ['organization' => $experience['organization'], 'position' => $experience['position']],
                [
                    'location' => $experience['location'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['end_date'] ?? null,
                    'is_current' => $experience['is_current'] ?? false,
                    'description' => $experience['description'],
                    'responsibilities' => $experience['responsibilities'],
                    'achievements' => $experience['achievements'] ?? [],
                    'organization_url' => $experience['organization_url'] ?? null,
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }

    private function seedProjects(): void
    {
        $categories = [
            'Web Applications' => 'layers',
            'APIs & Integrations' => 'cpu',
            'E-commerce' => 'chart',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $icon) {
            $categoryModels[$name] = ProjectCategory::query()->updateOrCreate(
                ['name' => $name],
                ['icon' => $icon, 'is_active' => true, 'sort_order' => count($categoryModels)],
            );
        }

        $projects = [
            [
                'category' => 'Web Applications',
                'title' => 'Multi-tenant SaaS Platform',
                'subtitle' => 'A billing and workflow platform used by thousands of small businesses.',
                'short_description' => 'A modular, multi-tenant Laravel application with per-tenant isolation, subscriptions and a Filament admin.',
                'technologies' => ['Laravel', 'Livewire', 'Filament', 'PostgreSQL', 'Redis', 'Stripe'],
                'role' => 'Lead Developer',
                'client' => 'Acme Digital',
                'timeline' => '18 months',
                'image' => ['#820B5C', '#1A0262'],
            ],
            [
                'category' => 'E-commerce',
                'title' => 'E-commerce Storefront & Admin',
                'subtitle' => 'A complete store with inventory, checkout and order management.',
                'short_description' => 'A headless storefront with a Laravel API backend, Vue.js storefront and Stripe checkout.',
                'technologies' => ['Laravel', 'Vue.js', 'Inertia', 'MySQL', 'Stripe'],
                'role' => 'Full-Stack Developer',
                'client' => 'Northwind Retail',
                'timeline' => '9 months',
                'image' => ['#2563EB', '#1A0262'],
            ],
            [
                'category' => 'APIs & Integrations',
                'title' => 'REST API for Mobile Apps',
                'subtitle' => 'A versioned API powering iOS and Android applications.',
                'short_description' => 'A secure, token-based API with rate limiting, caching and comprehensive documentation.',
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'Redis', 'Scribe'],
                'role' => 'API Developer',
                'client' => 'Northwind Labs',
                'timeline' => '4 months',
                'image' => ['#7C3AED', '#2563EB'],
            ],
            [
                'category' => 'APIs & Integrations',
                'title' => 'Payment Gateway Integration',
                'subtitle' => 'Reliable payments with webhooks, retries and reconciliation.',
                'short_description' => 'An integration layer connecting a Laravel application to Stripe, handling webhooks and idempotent billing.',
                'technologies' => ['Laravel', 'Stripe', 'Queues', 'MySQL'],
                'role' => 'Backend Developer',
                'client' => 'Acme Digital',
                'timeline' => '3 months',
                'image' => ['#820B5C', '#2563EB'],
            ],
            [
                'category' => 'Web Applications',
                'title' => 'Business Dashboard & Reporting',
                'subtitle' => 'Live metrics and reporting for leadership teams.',
                'short_description' => 'A real-time dashboard aggregating data from multiple systems with charts, exports and alerts.',
                'technologies' => ['Laravel', 'Livewire', 'Chart.js', 'PostgreSQL'],
                'role' => 'Lead Developer',
                'client' => 'Northwind Labs',
                'timeline' => '6 months',
                'image' => ['#0EA5E9', '#1A0262'],
            ],
            [
                'category' => 'Web Applications',
                'title' => 'Legacy App Migration',
                'subtitle' => 'Moving a fragile legacy system onto a modern Laravel stack.',
                'short_description' => 'A phased migration of a decade-old PHP system onto Laravel, with tests added along the way.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Pest'],
                'role' => 'Developer',
                'client' => 'Bluebird Studio',
                'timeline' => '12 months',
                'image' => ['#7C3AED', '#820B5C'],
            ],
        ];

        foreach ($projects as $index => $project) {
            $image = $this->image('project-'.($index + 1).'.svg', $project['title'], $project['image'][0], $project['image'][1]);

            Project::query()->updateOrCreate(
                ['title' => $project['title']],
                [
                    'project_category_id' => $categoryModels[$project['category']]->id,
                    'subtitle' => $project['subtitle'],
                    'short_description' => $project['short_description'],
                    'overview' => $project['subtitle'],
                    'problem' => 'The existing process was manual, slow and difficult to scale. Stakeholders needed a system that would handle growth without constant intervention.',
                    'approach' => 'I started by mapping the workflow with the team, then designed a modular architecture and shipped it in small, tested increments.',
                    'solution' => 'The finished application replaced the manual process with an automated, well-tested system, giving the team a single source of truth.',
                    'result' => 'The project delivered measurable time savings, fewer errors, and a platform the team could confidently extend.',
                    'role' => $project['role'],
                    'client' => $project['client'],
                    'timeline' => $project['timeline'],
                    'technologies' => $project['technologies'],
                    'status' => 'completed',
                    'featured_image' => $image,
                    'external_url' => 'https://example.com',
                    'github_url' => 'https://github.com/bpparajuli',
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $index,
                    'seo_title' => $project['title'],
                    'seo_description' => $project['short_description'],
                ],
            );
        }
    }

    private function seedCurrently(): void
    {
        $items = [
            ['label' => 'Learning', 'value' => 'Deep-diving into Laravel 11 and event-driven architecture.', 'icon' => 'book'],
            ['label' => 'Building', 'value' => 'A multi-tenant SaaS boilerplate built with Filament.', 'icon' => 'layers'],
            ['label' => 'Reading', 'value' => 'Team Topologies by Matthew Skelton and Manuel Pais.', 'icon' => 'book'],
            ['label' => 'Exploring', 'value' => 'Serverless Laravel deployments with Laravel Vapor.', 'icon' => 'sparkles'],
        ];

        foreach ($items as $index => $item) {
            CurrentlyItem::query()->updateOrCreate(
                ['label' => $item['label']],
                [
                    'value' => $item['value'],
                    'icon' => $item['icon'],
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }

    private function seedPages(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'excerpt' => 'How this website collects and uses data.',
                'content' => "<p>This website is a portfolio for B. P. Parajuli. I respect your privacy and aim to be transparent about how data is handled.</p>\n\n<h2>Information collected</h2>\n<p>When you submit the contact form, I collect the name, email address, and message you provide so I can respond to your enquiry.</p>\n\n<h2>How information is used</h2>\n<p>Your details are used only to respond to your enquiry. They are never sold or shared with third parties.</p>\n\n<h2>Cookies</h2>\n<p>This site may use essential cookies required for it to function correctly.</p>",
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'excerpt' => 'The terms under which this website is provided.',
                'content' => "<p>By using this website you agree to these terms. The content on this site is provided for general information purposes.</p>\n\n<h2>Use of content</h2>\n<p>You may not reproduce or redistribute the content of this site without permission.</p>\n\n<h2>No warranty</h2>\n<p>The site is provided on an as-is basis, and no guarantees are made about its availability or accuracy.</p>",
            ],
        ];

        foreach ($pages as $page) {
            Page::query()->updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'excerpt' => $page['excerpt'],
                    'content' => $page['content'],
                    'template' => 'default',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 0,
                ],
            );
        }
    }

    private function seedUsers(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'B. P. Parajuli',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'job_title' => 'Laravel Developer',
                'email_verified_at' => now(),
            ],
        );
    }

    private function image(string $filename, string $label, string $from, string $to, int $width = 1200, int $height = 750): string
    {
        $dir = public_path('images');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $monogram = collect(preg_split('/\s+/', trim($label)) ?: [])
            ->filter()
            ->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');

        $fontSize = (int) round($width * 0.2);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{$from}"/>
      <stop offset="1" stop-color="{$to}"/>
    </linearGradient>
  </defs>
  <rect width="{$width}" height="{$height}" fill="url(#g)"/>
  <circle cx="{$width}" cy="0" r="{$height}" fill="#ffffff" opacity="0.08"/>
  <circle cx="0" cy="{$height}" r="{$height}" fill="#000000" opacity="0.10"/>
  <text x="50%" y="54%" font-family="Arial, Helvetica, sans-serif" font-size="{$fontSize}" font-weight="700" fill="#ffffff" fill-opacity="0.85" text-anchor="middle" dominant-baseline="middle" letter-spacing="6">{$monogram}</text>
</svg>
SVG;

        file_put_contents($dir.DIRECTORY_SEPARATOR.$filename, $svg);

        return '/images/'.$filename;
    }
}
