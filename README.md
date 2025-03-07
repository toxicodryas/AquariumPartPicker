# AquariumPartPicker

AquariumPartPicker is a web application inspired by PCPartPicker, designed to help aquarium enthusiasts select compatible components for their aquarium builds. The application allows users to browse various aquarium components, create custom builds, check component compatibility, and share their builds with the community.

## Features

- **Component Browser**: Browse a comprehensive catalog of aquarium components, including tanks, filters, lights, heaters, and more.
- **Build Creator**: Create custom aquarium builds by selecting compatible components.
- **Compatibility Checker**: Receive real-time feedback on component compatibility (e.g., if a filter is appropriate for your tank size).
- **User Accounts**: Register and log in to save your builds for future reference.
- **Community Sharing**: Share your builds with the community and view others' builds for inspiration.
- **Price Tracking**: See the current prices for all components and total build cost.

## Technology Stack

- **Laravel**: PHP framework providing the application backend
- **Livewire**: Full-stack framework for dynamic interfaces with minimal JavaScript
- **Alpine.js**: Minimal JavaScript framework for frontend interactivity
- **MySQL**: Database system for storing component and user data
- **Tailwind CSS**: Utility-first CSS framework for styling

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL
- Laravel CLI

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/aquarium-part-picker.git
cd aquarium-part-picker
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create a copy of the `.env.example` file:
```bash
cp .env.example .env
```

5. Generate an application key:
```bash
php artisan key:generate
```

6. Configure your database connection in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aquarium_part_picker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations and seed the database:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run dev
```

9. Start the development server:
```bash
php artisan serve
```

The application should now be running at `http://localhost:8000`.

## Database Setup

1. Create a MySQL database:
```bash
mysql -u root -p
CREATE DATABASE aquarium_part_picker;
```

2. Create a dedicated user (optional but recommended):
```sql
CREATE USER 'aquarium_user'@'localhost' IDENTIFIED BY 'your_password_here';
GRANT ALL PRIVILEGES ON aquarium_part_picker.* TO 'aquarium_user'@'localhost';
FLUSH PRIVILEGES;
```

3. Update your `.env` file with these credentials.

## Project Structure

The application follows the standard Laravel directory structure with Livewire components:

- `app/Models/`: Contains database models (AquariumTank, Filter, Light, etc.)
- `app/Livewire/`: Contains Livewire components (PartBrowser, BuildCreator, etc.)
- `database/migrations/`: Database migration files
- `database/seeders/`: Seed data for populating the database
- `resources/views/livewire/`: Blade view templates for Livewire components
- `resources/views/layouts/`: Application layout templates
- `routes/web.php`: Web route definitions

## Key Components

### Models

- `AquariumTank`: Represents aquarium tanks with dimensions, volume, glass type, etc.
- `Filter`: Represents aquarium filters with flow rate, tank size recommendations, etc.
- `Light`: Represents aquarium lights with spectrum, wattage, dimensions, etc.
- `Heater`: Represents aquarium heaters with wattage and tank size recommendations.
- `Build`: Represents a user's saved aquarium build.
- `BuildItem`: Represents a component in a build.

### Livewire Components

- `PartBrowser`: Allows users to browse and search for components.
- `BuildCreator`: Interface for creating and saving builds.
- `CompatibilityChecker`: Checks compatibility between selected components.
- `PriceComparison`: Compares prices of components across different sources.

## Usage

### Browsing Components

Navigate to the "Browse Parts" section to view available components. You can filter by component type (tanks, filters, lights, heaters) and sort by various attributes.

### Creating a Build

1. Navigate to the "Build" section.
2. Select a tank as your base component.
3. Add compatible filters, lights, heaters, and other components.
4. The application will automatically check component compatibility and display warnings if issues are detected.
5. Save your build if you're logged in.

### Managing Saved Builds

If you're logged in, you can:
- View your saved builds
- Edit existing builds
- Share builds publicly
- Clone builds from other users

## Development

### Adding New Component Types

To add a new component type (e.g., substrate):

1. Create a migration and model:
```bash
php artisan make:model Substrate -m
```

2. Define the database schema in the migration file.

3. Update the PartBrowser and BuildCreator components to include the new component type.

### Custom Compatibility Rules

Compatibility rules are defined in the `checkCompatibility` method of the BuildCreator component. You can enhance these rules by:

1. Editing the `app/Livewire/BuildCreator.php` file.
2. Adding new conditional checks to the `checkCompatibility` method.
3. Defining warning messages for incompatible components.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Inspired by PCPartPicker
- Built with Laravel and Livewire
- Styled with Tailwind CSS
