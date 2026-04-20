# Recruitment platform

A Laravel job board where candidates search and apply, employers post listings (with admin approval), and staff manage companies, jobs, and applications.

**Live demo:** [https://recruitment-platform-eck9.onrender.com/](https://recruitment-platform-eck9.onrender.com/)

---

## Stack and packages

| Layer | Technology |
| --- | --- |
| Framework | [Laravel](https://laravel.com/docs) **13.x** (PHP **^8.3**) |
| Auth UI | [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) (Blade + Tailwind) |
| Admin interactivity | [Livewire](https://livewire.laravel.com/) **4.x** |
| Front-end build | [Vite](https://vitejs.dev/) **8.x**, [laravel-vite-plugin](https://github.com/laravel/vite-plugin) |
| CSS (Breeze) | [Tailwind CSS](https://tailwindcss.com/) **3.x**, [@tailwindcss/forms](https://github.com/tailwindlabs/tailwindcss-forms) |
| JS (Breeze) | [Alpine.js](https://alpinejs.dev/) **3.x** |
| HTTP client | [Axios](https://axios-http.com/) |
| Admin / candidate dashboards | [Bootstrap 5](https://getbootstrap.com/) (CDN in Blade layouts) |
| Dev | PHPUnit, Laravel Pint, Laravel Pail, Faker, Collision |

**Composer highlights:** `laravel/framework`, `livewire/livewire`, `laravel/tinker`  
**NPM highlights:** `vite`, `tailwindcss`, `alpinejs`, `concurrently`

---

## Requirements

- PHP **8.3+** with common extensions (mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) **18+** and npm

---

## Install (local)

1. **Clone and enter the project**

   ```bash
   git clone <repository-url>
   cd recruitment-platform
   ```

2. **Environment**

   ```bash
   copy .env.example .env   # Windows; use cp on macOS/Linux
   php artisan key:generate
   ```

   Configure `.env`: `APP_URL`, `DB_*` (SQLite file or MySQL/PostgreSQL), `MAIL_*` if you need email (e.g. job-returned-to-pending notices).

3. **Database**

   ```bash
   # SQLite (example)
   type nul > database\database.sqlite   # Windows; touch database/database.sqlite on Unix

   php artisan migrate
   ```

4. **Optional: demo data** (test users, companies, jobs, applications)

   ```bash
   php artisan db:seed
   ```

   See [Test accounts](#test-accounts-after-dbseed) below.

5. **Assets**

   ```bash
   composer install
   npm install
   npm run build          # production assets
   # or during development:
   npm run dev
   ```

6. **Storage link** (if you serve uploaded CVs from `public/storage`)

   ```bash
   php artisan storage:link
   ```

7. **Run the app**

   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000` (or your `APP_URL`).

**One-shot setup** (after `.env` and DB exist):

```bash
composer run setup
```

---

## Usage by role

After login, users are sent to the right area automatically (`/admin`, `/company`, or `/dashboard` for candidates).

### Candidate (`role: candidate`)

- **Register:** `/register` — standard candidate signup.
- **Dashboard:** `/dashboard` — sidebar: **Find job**, **My applications**, **Change profile**.
- **Public job board:** `/` — search by keyword and location; only **published** jobs are listed.
- **Job detail & apply:** `/jobs/{id}` — apply with optional cover letter and CV (logged-in candidates only).

### Company / employer (`role: company`)

- **Register:** `/register/company` — creates user + company profile.
- **Dashboard:** `/company` — **My jobs**, **Applications** (all listings), **Post a job**, **Profile**.
- New jobs are **pending** (`is_published = false`) until staff publishes them.
- Editing a **published** job and changing title, description, location, or salary sets it back to **pending**; admins are notified by email (if mail is configured).

### Admin (`role: admin`)

- Same back-office access as super admin **except** managing other staff accounts.
- **Panel:** `/admin` — dashboard counts, jobs, companies, applications, create job/company, **Pending employer jobs** queue (`/admin/jobs/pending-employer`).
- Uses Livewire tables where configured (e.g. jobs list, pending queue).

### Super admin (`role: super_admin`)

- Everything **admin** can do, plus:
- **Manage admin users:** `/admin/staff` — list users with roles `admin` / `super_admin`, add accounts, delete others (cannot delete self or the last super admin).
- Dashboard card **Manage admin users** and sidebar **Admin staff** (super admin only).

---

## Test accounts (after `db:seed`)

Password for all seeded test users: **`password`**

| Role | Email | Notes |
| --- | --- | --- |
| Super admin | `superadmin@test.com` | Staff management |
| Admin | `admin@test.com` | Back office, no `/admin/staff` |
| Company | `company1@test.com`, `company2@test.com` | Linked to Tech Corp / Startup Inc |
| Candidate | `candidate1@test.com`, `candidate2@test.com`, `candidate3@test.com` | Can apply to published jobs |

`DatabaseSeeder` also creates `test@example.com` (default **candidate** role) via the factory.

---

## Tests

```bash
composer run test
# or
php artisan test
```

---

## Deployment notes (e.g. Render)

The public demo runs at [https://recruitment-platform-eck9.onrender.com/](https://recruitment-platform-eck9.onrender.com/). For production:

- Set `APP_ENV=production`, `APP_DEBUG=false`, strong `APP_KEY`.
- Run `php artisan migrate --force` on deploy.
- Run `npm run build` (or build assets in CI) and `php artisan config:cache` / `route:cache` as needed.
- Configure `MAIL_*` for notifications.
- Use a persistent database and file storage (or S3) for uploads.

---

## License

This application builds on Laravel and related packages; see each package’s license (Laravel is [MIT](https://opensource.org/licenses/MIT)).
