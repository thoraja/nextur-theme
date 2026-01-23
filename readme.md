# Nextur Theme

A modern, high-performance custom WordPress theme designed for the Nextur Travel Agency. This theme leverages a "low-code" build approach using Tailwind CSS (CDN) and Alpine.js for a lightweight, reactive frontend without complex compilation steps.

## 🚀 Tech Stack

*   **Core**: WordPress (PHP)
*   **Styling**: Tailwind CSS v3.4 (via CDN with Typography plugin)
*   **Interactivity**: Alpine.js v3.0
*   **Date Handling**: Flatpickr
*   **Fonts**: Inter & Poppins (Google Fonts)
*   **Icons**: Heroicons (SVG inline) & Dashicons

## ✨ Key Features

### 1. Trip Management System (CPT)
The theme includes a robust Custom Post Type called **Trips** (`trip`), featuring:
*   **Custom Meta Boxes**:
    *   **Header**: Year tags, Airline, Route, Price, Featured toggle.
    *   **Context**: Subtitles and Highlights.
    *   **Itinerary Builder**: A dynamic repeater field to add day-by-day details (Title, Flight, Meals, Description).
    *   **Financials**: Min Pax, Deposit, Infant Price, Visa Notes.
    *   **Details**: Rich text editors for Includes, Excludes, Optional Add-ons, and Terms.
    *   **Gallery**: Custom media uploader for trip-specific galleries.
*   **Taxonomies**:
    *   **Destinations**: Hierarchical (e.g., Asia > Indonesia > Bali).
    *   **Activities**: Non-hierarchical (e.g., Hiking, Diving, Leisure). Includes a custom image uploader for the homepage "Lifestyle" slider.

### 2. Interactive Homepage
*   **Hero Slider**: Full-screen, touch-enabled slider built with Alpine.js.
*   **Trip Carousel**: Horizontal scrolling list of trips with category filtering (Alpine.js).
*   **Lifestyle/Activity Slider**: Visual navigation based on trip types.
*   **Destination Slider**: Visual navigation based on locations.
*   **Gallery/Highlights**: A dedicated CPT (`gallery_item`) for "Indo Highlights" displayed as a slider.

### 3. Multilingual Support (Polylang)
*   Deep integration with the **Polylang** plugin.
*   **String Registration**: Custom strings (Company Info, UI labels, Form placeholders) are registered via `inc/polylang.php`.
*   **Language Switcher**: Custom-styled dropdowns in both Desktop and Mobile headers.

### 4. Utilities & Tools
*   **JSON Trip Importer**: A specialized page template (`page-importer.php`) allowing bulk import of trips via JSON payload. It automatically handles bilingual linking (ID <-> EN) and taxonomy creation.
*   **Interactive Documentation**: A dedicated "Theme Docs" page in the Admin Dashboard containing user guides and AI prompts for the importer.
*   **Centralized Company Info**: A settings page to manage Addresses, Phone Numbers, and Social Media links globally.
*   **Content Protection**: Optional "Copy Protection" mode to disable right-click, text selection, and drag-and-drop actions to protect site content. Managed via "Theme Settings".

## 📂 File Structure

```text
nextur-theme/
├── assets/
│   ├── images/          # Logos and static assets
│   └── js/              # Admin scripts
├── inc/                 # Core Functionality
│   ├── company-info.php # Theme Settings Page
│   ├── documentation.php# Admin Documentation Page
│   ├── forms.php        # Contact Form Logic
│   ├── helpers.php      # Helper functions
│   ├── meta-boxes.php   # Trip CPT Meta Boxes
│   ├── polylang.php     # String Translations
│   ├── post-types.php   # CPT Registration
│   └── setup.php        # Theme Setup & Enqueue
├── functions.php        # Main Loader
├── header.php           # Glassmorphism header, Nav
├── footer.php           # Footer with dynamic company info
├── front-page.php       # Homepage layout
├── page-about.php       # "About Us" template
├── page-contact.php     # "Contact Us" template with Form
├── page-services.php    # "Services" template
├── page-importer.php    # Internal tool for JSON imports
├── page-thank-you.php   # Redirect page for forms
└── style.css            # Theme declaration
```

## 🛠️ Installation & Setup

1.  **Install Theme**: Upload the `nextur-theme` folder to `wp-content/themes/` and activate it via the WordPress Dashboard.
2.  **Install Plugins**:
    *   **Polylang** (Required): For multilingual support.
    *   *(Optional)* **Classic Editor**: If you prefer the classic interface for meta boxes.
3.  **Configure Polylang**:
    *   Add languages: **Indonesian (id)** and **English (en)**.
    *   Go to *Languages > String Translations* to translate UI strings.
4.  **Create Pages**:
    *   **Home**: Create a page, assign the `Front Page` template, and set as static homepage.
    *   **About**: Assign the `About Page` template.
    *   **Services**: Assign the `Services Page` template.
    *   **Contact**: Assign the `Contact Page` template.
    *   **Importer**: Create a private page, assign the `Interactive Trip Importer` template.
5.  **Setup Company Info**:
    *   Go to **Company Info** in the admin sidebar.
    *   Fill in Address, Phone, Email, and Social Media URLs.
    *   These details will automatically populate the Footer and Contact Page.

## 📝 Usage Guide

### Using the Batch Importer
1.  Go to **Theme Docs** > **Import Tool (AI)**.
2.  Copy the **System Instruction**.
3.  Paste it into ChatGPT/Gemini along with your itinerary document.
4.  Copy the JSON result.
5.  Go to the **Importer Page** on your frontend (must be logged in).
6.  Paste JSON and run.

### Managing Content
*   **Trips**: Add/Edit trips via the "Trips" menu. Use the "Dynamic Itinerary" meta box to build day-by-day schedules.
*   **Highlights**: Manage the "Indo Highlights" slider via the "Indo Highlights" menu.
*   **Company Details**: Update globally via the "Company Info" menu.

## 🎨 Customization

*   **Colors & Fonts**: Defined in `inc/setup.php` or `header.php` (Tailwind config).
    *   Brand Color: `#0284C7` (Sky 600)
*   **Icons**: Uses standard SVG paths inline.

## 🔒 Security

*   Hardening rules applied in `inc/helpers.php` (XML-RPC disabled, Version hidden).