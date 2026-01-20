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
*   **String Registration**: Custom strings (Company Info, UI labels, Form placeholders) are registered in `functions.php` for easy translation in WP Admin.
*   **Language Switcher**: Custom-styled dropdowns in both Desktop and Mobile headers.

### 4. Utilities & Tools
*   **JSON Trip Importer**: A specialized page template (`page-importer.php`) allowing bulk import of trips via JSON payload. It automatically handles bilingual linking (ID <-> EN) and taxonomy creation.
*   **Booking & Contact Forms**: Built-in form handlers (`admin-post` hooks) that send styled HTML emails to the administrator and redirect users to a Thank You page.

## 📂 File Structure

```text
nextur-theme/
├── assets/
│   ├── images/          # Logos and static assets
│   └── js/
│       └── admin-gallery.js  # JS for handling media uploaders in Admin
├── functions.php        # Core logic, CPTs, Meta Boxes, Form Handlers, Enqueue
├── header.php           # Glassmorphism header, Nav, Alpine.js Mobile Menu
├── footer.php           # (Standard footer template)
├── front-page.php       # The main homepage layout
├── page-about.php       # "About Us" template
├── page-accomodation.php # "Accommodation" (Coming Soon) template
├── page-importer.php    # Internal tool for JSON imports
├── style.css            # Theme declaration
└── README.md            # Documentation
```

## 🛠️ Installation & Setup

1.  **Install Theme**: Upload the `nextur-theme` folder to `wp-content/themes/` and activate it via the WordPress Dashboard.
2.  **Install Plugins**:
    *   **Polylang** (Required): For multilingual support.
    *   *(Optional)* **Classic Editor**: If you prefer the classic interface for meta boxes.
3.  **Configure Polylang**:
    *   Add languages: **Indonesian (id)** and **English (en)**.
    *   Go to *Languages > String Translations* to translate UI strings (e.g., "Hubungi Kami", "Mulai dari").
4.  **Create Pages**:
    *   **Home**: Create a page, assign the `Front Page` template (or just leave default if using `front-page.php`), and set it as the static homepage in *Settings > Reading*.
    *   **About**: Create a page and assign the `About Page` template.
    *   **Importer**: Create a private page and assign the `Interactive Trip Importer` template.
    *   **Thank You**: Create a page with slug `thank-you` for form redirects.
5.  **Setup Menus**:
    *   Go to *Appearance > Menus*.
    *   Create a "Primary Menu" and assign it to the `Primary Menu` location.

## 📝 Usage Guide

### Adding a New Trip
1.  Go to **Trips > Add New**.
2.  Enter the Title.
3.  **Right Sidebar**: Select **Destination** and **Activity**.
4.  **Meta Boxes**:
    *   Fill in Airline, Route, Price.
    *   Check **"Featured on Homepage?"** to add it to the main Hero Slider.
    *   Use the **Dynamic Itinerary** section to add days.
    *   Upload images to the **Trip Gallery**.
5.  **Translation**: Click the (+) icon in the Languages box to add the translation for the other language.

### Managing Homepage Highlights
1.  Go to **Indo Highlights** (Gallery Items).
2.  Add New Item.
3.  **Title**: City/Location Name.
4.  **Featured Image**: The visual card image.
5.  **Destination Link**: URL to the specific destination archive or trip page.

### Using the Importer
1.  Navigate to the page assigned to the **Interactive Trip Importer** template.
2.  Paste the JSON payload (structure defined in `page-importer.php`).
3.  Click **Run Importer**.
4.  The tool will create/update trips, assign taxonomies, and link English/Indonesian versions automatically.

## 🎨 Customization

*   **Colors & Fonts**: Defined in `functions.php` under `tailwind.config`.
    *   Brand Color: `#0284C7` (Sky 600)
    *   Fonts: Inter (Body), Poppins (Heading)
*   **Icons**: Uses standard SVG paths in PHP files. To change icons, replace the `<svg>` tags.

## 🔒 Security

The theme implements basic hardening in `functions.php`:
*   Disables XML-RPC.
*   Hides WP Version.
*   Blocks user enumeration scans.