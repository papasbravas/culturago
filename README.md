# Cultural Events App

## Overview
The Cultural Events App is a PHP-based web application designed to manage and display cultural events. It allows users to browse events, make reservations, and manage their favorite events. The application also includes an administrative interface for managing users and events.

## Directory Structure
```
cultural-events-app
├── public
│   └── index.php
├── src
│   ├── modelos
│   │   ├── class.usuarios.php
│   │   ├── class.reservas.php
│   │   ├── class.events.php
│   │   ├── class.categorias.php
│   │   ├── class.favorita.php
│   │   └── class.notificaciones.php
│   ├── controladores
│   │   ├── AmigosController.php
│   │   ├── AdminController.php
│   │   ├── EventController.php
│   │   └── AuthController.php
│   └── vistas
│       ├── landing.php
│       ├── eventos.php
│       └── admin
│           └── dashboard.php
├── config
│   └── conexion.php
├── composer.json
└── README.md
```

## Setup Instructions
1. **Clone the repository**:
   ```
   git clone <repository-url>
   cd cultural-events-app
   ```

2. **Install dependencies**:
   Make sure you have Composer installed, then run:
   ```
   composer install
   ```

3. **Configure the database connection**:
   Edit the `config/conexion.php` file to set your database credentials.

4. **Run the application**:
   You can use a local server like XAMPP or MAMP to run the application. Place the project in the server's root directory and access it via your web browser.

## Usage Guidelines
- Users can register, log in, and manage their profiles.
- Users can browse events, make reservations, and save favorite events.
- Admin users can manage events and users through the admin dashboard.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.