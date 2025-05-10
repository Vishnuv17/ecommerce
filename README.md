
# 🛒 PHP eCommerce Website

A simple eCommerce website built with PHP and MySQL. Users can browse products, add them to the cart, update quantities, place orders, and view summaries as admin.

---

## 🛠 Tech Stack Used

- **Frontend:**
  - HTML5, CSS3
  - Font Awesome & Boxicons
- **Backend:**
  - PHP (Procedural)
  - MySQL
- **Tools:**
  - XAMPP / WAMP / MAMP (for local development)
  - phpMyAdmin (for database management)

---

## ⚙️ Setup Instructions

1. **Download the source code:**



2. **Import the database:**

   - Open `phpMyAdmin`.
   - Create a new database (e.g., `ecommerce_db`).
   - Import the `ecommerce_db.sql` file (located in the project root or `/database` folder).

3. **Configure the database connection:**

   In `config.php`, set your DB credentials:

   ```php
   $conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
   ```

4. **Start your local server:**

   - Place the project folder in the `htdocs` directory (if using XAMPP).
   - Start **Apache** and **MySQL** from XAMPP.
   - Visit `http://localhost/ecommerce/index.php` in your browser.

---

## 🔐 Sample Credentials

### User Account
- **Email:** user@example.com
- **Password:** 123456

*(These should match what you’ve seeded or manually inserted into your database.)*

---

## 📝 Notes / Trade-offs

- ❗ **Security Trade-offs:**
  - Passwords are stored in plain text (for simplicity). In production, use password hashing (`password_hash()`).
  - No CSRF or XSS protection yet.

- 🧪 **Simple Cart Logic:**
  - Cart is session-based and stored in `$_SESSION`.
  - Quantities can be updated directly from the checkout page.

- 💬 **Minimal JavaScript:**
  - Mostly HTML/CSS/PHP with minimal or no JavaScript to keep things simple and avoid dependency bloat.

- 🧩 **Admin Dashboard:**
  - Built inside a single PHP file (`admin.php`), includes order summaries, grouping, and stats.

---

## 📷 Screenshots

![Screenshot_10-5-2025_202112_localhost](https://github.com/user-attachments/assets/a4d451e1-8e19-4a27-94c7-770bd63282d7)
![Screenshot_10-5-2025_202130_localhost](https://github.com/user-attachments/assets/67adea42-8272-4ec1-b975-a9009f5dff41)
![Screenshot_10-5-2025_201742_localhost](https://github.com/user-attachments/assets/a60173b8-4c6c-4deb-908a-87c585845bd5)
![Screenshot_10-5-2025_202220_localhost](https://github.com/user-attachments/assets/7c92d173-6175-4093-962f-939b8db5e6d0)
![Screenshot_10-5-2025_201926_localhost](https://github.com/user-attachments/assets/903a087c-010f-4b01-9c34-836c3bd8522e)
![Screenshot_10-5-2025_202015_localhost](https://github.com/user-attachments/assets/2471499d-0b6e-4ecd-9452-69ee8bc9d28b)




---

## 📩 Contact

**Vishnu V**  
🌍 [Website](https://vishnuofficial17.netlify.app/)
📧 [vishnuv1708@gmail.com](mailto:vishnuv1708@gmail.com)  
🔗 [LinkedIn](https://www.linkedin.com/in/vishnuv1708) | [GitHub](https://github.com/Vishnuv17)

---
