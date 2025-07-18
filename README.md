
---

```markdown
# 💰 Expense Tracker — Personal & Team Dashboard

A full-featured **Core PHP + MySQL** expense tracking system with both **personal** and **team** dashboards. It includes full CRUD for expenses, invite-based team access, interactive charts, animations, light/dark mode, and secure session-based routing.

---

## 📸 Preview (Infographic)

```

---

## ⚙️ Tech Stack

- Core PHP (`mysqli`)
- MySQL (uses stored procedures)
- TailwindCSS (for modern UI)
- Chart.js, D3.js (interactive charts)
- Anime.js + Canvas (for animated background)
- jQuery (DOM & AJAX helpers)
- SweetAlert2 (for alerts and modals)
- Intro.js (guided tours)
- `.env` for config
- Secure sessions + page protection

---

## 🚀 Setup (Localhost via WAMP)

### 1. 🔽 Download or Clone

```bash
git clone https://github.com/your-username/expense-tracker.git
````

### 2. 🗃️ Create Database

* Open **phpMyAdmin**
* Create DB: `expense_tracker`
* Import: `/database/schema.sql`
* Optionally: Run `populate.php` (dev seeder)

### 3. ⚙️ Configure `.env`

Create a `.env` file at project root:

```
DB_HOST=localhost
DB_NAME=expense_tracker
DB_USER=root
DB_PASS=
```

### 4. 🌐 Set Virtual Host (Optional)

In WAMP, map:

```
http://expenses/ → /public
```

Or simply open:

```
http://localhost/expense-tracker/public/
```

---

## 📁 Folder Structure

```
/db/
  └── db.php            ← Secure DB config using .env

/public/
├── index.php           ← Animated landing page
├── login.php
├── register.php
├── dashboard.php       ← For personal accounts
├── team_dashboard.php  ← For team members
├── logout.php
├── assets/
│   ├── css/theme.css
│   └── js/
│       ├── darkmode.js
│       └── landing-animation.js
└── api/
    ├── auth/
    │   ├── login.php
    │   └── logout.php
    ├── register/
    │   └── create.php
    ├── expense/
    │   ├── add.php
    │   ├── delete.php
    │   ├── list_user.php
    │   ├── list_team.php
    │   └── get_team.php
    └── team/
        └── generate_code.php

/database/
├── schema.sql
├── procedures.sql
└── populate.php (dev-only)
```

---

## ✨ Key Features

* 🔐 Session-based routing & redirection
* 🔁 Toggle between personal & team dashboards
* 👥 Invite system with token-based team join
* 🧾 Add, view, delete expenses
* 📊 Charts per category and contributor
* 📦 Total team spend visualized
* 🌗 Light/Dark Mode toggle
* 🎯 Team attribution per expense (owner/member)
* 🎨 Modern UI (claymorphism, glassmorphism)
* 🎉 Intro.js onboarding for new users

---

## 🙌 How to Contribute

```bash
git checkout -b feature/new-feature
git commit -m "Add new feature"
git push origin feature/new-feature
```

* Fork → Feature Branch → Pull Request
* Keep code readable and modular

---

## 🧠 Credits

Built by [**Kumar Sutikshan**](https://www.linkedin.com/in/kumar-sutikshan)

✉️ [kumarsutikshan.1@gmail.com](mailto:kumarsutikshan.1@gmail.com)
📱 +91-9453993869

---

```
