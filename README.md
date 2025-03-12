
```markdown
# Rank Tracker

Rank Tracker is a powerful, feature-rich SEO tool designed to help users track keyword performance, analyze competitors, and gain detailed insights into their site's search visibility. Built on **Laravel 11** with best practices in backend development, this tool offers a robust API for managing keyword progress, competitor performance, and site ranking metrics.

---

## Features

### Core Features

- **Keyword Progress Tracking**: Track the ranking progress of specific keywords over time for multiple sites.
- **Top 3 & Top 10 Rankings**: Retrieve the top-ranked sites (1-3, 1-10) for a keyword within a defined date range.
- **Average Position Calculation**: Calculate the average keyword ranking position for a group of sites and keywords.
- **Competitor Analysis**: Analyze competitors' performance including search volume and ranking history.
- **Position Flow**: Track changes in keyword rankings (up, down, or unchanged) for specific sites and keywords.
- **Comprehensive Site Insights**: Retrieve detailed information about a site’s keyword ranking history and performance.

---

## API Endpoints

The following API endpoints are available for interacting with the system:

### Site Details API

**Base URL**: `/site-details`

**Authentication**: Requires **Sanctum Authentication** and **`manage-sites`** permission.

- **POST** `/site-details/progress`  
  Track keyword progress for a specific site and keyword.

- **POST** `/site-details/top3`  
  Retrieve the top 3 ranked sites for a keyword within a specific date range.

- **POST** `/site-details/top10`  
  Retrieve the top 10 ranked sites for a keyword within a specified date range.

- **POST** `/site-details/average-position`  
  Calculate the average ranking position of a set of keywords for one or more sites.

- **GET** `/site-details/analyze/{siteId}`  
  Analyze and gather keyword performance data for a given site.

- **POST** `/site-details/competitors/average-history`  
  Get historical average keyword ranking data for competitors.

- **POST** `/site-details/competitors/top3`  
  Retrieve the top 3 competitors for a keyword.

- **POST** `/site-details/competitors/top10`  
  Retrieve the top 10 competitors for a keyword.

- **POST** `/site-details/competitors/search-volume`  
  Get competitors' search volume rankings for a keyword.

- **GET** `/site-details/position-flow/{siteId}`  
  Track the movement of keyword rankings for a given site.

- **POST** `/site-details/details`  
  Retrieve detailed keyword ranking information for a site.

---

## Setup & Installation

To get started with the project, follow these steps:

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/rank-tracker.git
cd rank-tracker
```

### 2. Install Dependencies

Make sure you have **Composer** installed, then run:

```bash
composer install
```

### 3. Set Up Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Configure the `.env` file with your database and other service credentials. Add the following environment variables for the **Google SERP API**:

```env
GOOGLE_SERPER_API_KEY=your_api_key_here
GOOGLE_SERPER_API_URL=https://google.serper.dev/search
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations

To set up the database tables, run the migrations:

```bash
php artisan migrate --seed
```

### 6. Set Up Queues 

If you're using queues for background processing, configure your queue settings (e.g., Redis or database) in the `.env` file and start the queue worker:

```bash
php artisan queue:work --queue={queue_name}
```

### 7. Fetch Search Results and Insert Keywords

Run the following commands to fetch search results and insert keywords into the database:

#### Fetch Search Results
This command fetches search results from the **Google SERP API** and stores them in the database.

```bash
php artisan search:result
```

#### Insert Keywords
This command inserts keywords into the database for tracking.

```bash
php artisan keywords:insert
```

### 8. Start the Development Server

```bash
php artisan serve
```

Your application will now be available at `http://localhost:8000`.

---

## Usage

The API endpoints are protected by **Sanctum Authentication**. To authenticate, you need to send the appropriate API token in your requests.

### Example Authentication Flow:

1. **Login**: Obtain an API token by authenticating a user.
2. **Make API Calls**: Include the token in your headers for subsequent API calls.

Example header:

```bash
Authorization: Bearer {your-api-token}
```

### Example Request:

```bash
POST /site-details/progress
{
  "site_id": 1,
  "keyword_id": 2,
  "first_date": "2024-01-01",
  "last_date": "2024-02-01"
}
```

---

## Contributing

We welcome contributions! If you’d like to contribute to the project, follow these steps:

1. **Fork the repository**.
2. **Create a new feature branch** (`git checkout -b feature/your-feature`).
3. **Make your changes** and write tests.
4. **Commit your changes** (`git commit -m 'Add new feature'`).
5. **Push to your branch** (`git push origin feature/your-feature`).
6. **Open a pull request**.

---

## Acknowledgments

- **Laravel**: For powering this application.
- **Sanctum**: For secure API authentication.
- **Redis**: For caching and queue management.
- **Google SERP API**: For providing search result data.
---

## Contact

For any issues, feel free to open an issue in the GitHub repository or contact the project maintainers.

---

**Rank Tracker** is designed to empower webmasters, marketers, and SEO professionals with detailed performance insights and actionable data for improving search rankings and competitive advantage.
