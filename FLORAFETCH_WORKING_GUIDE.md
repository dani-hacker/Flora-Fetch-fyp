# 🌿 FloraFetch — Complete Working Guide
### (Har Feature ki Step-by-Step Working)

---

## 🌐 Website URLs

| Page | URL |
|------|-----|
| Home / Plant Catalog | http://localhost:8000 |
| Login | http://localhost:8000/login |
| Register | http://localhost:8000/register |
| Cart | http://localhost:8000/cart |
| Checkout | http://localhost:8000/checkout |
| My Orders | http://localhost:8000/orders |
| Admin Dashboard | http://localhost:8000/admin/dashboard |
| Admin Plants | http://localhost:8000/admin/plants |
| Admin Orders | http://localhost:8000/admin/orders |

---

## 🔑 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@florafetch.com | Admin@1234 |
| Customer | jane@example.com | Customer@1234 |

---

---

# 👤 CUSTOMER SIDE — Complete Working

---

## 1️⃣ Register (Naya Account Banana)

**URL:** http://localhost:8000/register

**Kaise kaam karta hai:**
1. Register page par jao
2. Apna Naam, Email, Password bharo
3. Password confirm karo
4. "Register" button click karo

**Rules:**
- Password minimum 8 characters hona chahiye
- Password mein letters aur numbers dono hone chahiye (jaise: `Pass1234`)
- Email unique honi chahiye (already registered email se dobara signup nahi hoga)

**Register hone ke baad:**
- Automatically login ho jaoge
- Home page (Plant Catalog) par redirect ho jaoge

---

## 2️⃣ Login

**URL:** http://localhost:8000/login

**Kaise kaam karta hai:**
1. Email aur Password dalo
2. "Remember Me" checkbox tick kar sakte ho (session save rehti hai)
3. "Login" button click karo

**Login ke baad:**
- ✅ **Admin** → Admin Dashboard par jaata hai (`/admin/dashboard`)
- ✅ **Customer** → Home page (Plant Catalog) par jaata hai

**Wrong password ho to:**
- Error show hoga: "The provided credentials do not match our records."

---

## 3️⃣ Plant Catalog (Home Page) — Browse Plants

**URL:** http://localhost:8000

**Kya dikh raha hoga:**
- Saare plants cards ki shakal mein
- Har plant ka: Naam, Category, Price (PKR), Sunlight, Watering info

**Filter Karna:**
- **Category** — Indoor / Outdoor / Succulents / Herbs
- **Sunlight** — Full Sun / Partial Shade / Low Light
- **Watering Need** — Low / Medium / High
- **Search** — Plant ka naam likh ke search karo

**Important:**
- Sirf **in-stock** plants show hote hain (stock = 0 wale nahi dikhte)
- Login ke bina "Login to Buy" button dikh ta hai
- Login ke baad "Add to Cart" button aata hai

---

## 4️⃣ Plant Detail Page

**URL:** http://localhost:8000/plants/{id}

**Kaise kaam karta hai:**
1. Kisi bhi plant card par click karo
2. Plant ki poori detail page khulegi

**Kya dikh raha hoga:**
- Plant ki image
- Naam, Category, Price
- Sunlight Requirement
- Watering Need
- Stock Quantity
- Description
- **Related Plants** (same category ke 4 plants neeche dikhenge)

**Add to Cart:**
- Quantity select karo (max stock tak)
- "Add to Cart" click karo
- Success message aayega

---

## 5️⃣ Cart (Tokri)

**URL:** http://localhost:8000/cart  
**Login zaruri hai**

**Cart mein kya kar sakte ho:**

| Action | Kaise |
|--------|-------|
| Item dekhna | `/cart` par jao — sab items list mein |
| Quantity update karna | Quantity field change karo → "Update" click karo |
| Item remove karna | "Remove" button click karo |
| Poora cart clear karna | "Clear Cart" button click karo |
| Total dekhna | Page ke neeche total amount show hota hai |

**Cart kaise store hoti hai:**
- Cart **session** mein save hoti hai
- Agar logout karo to cart clear ho jaati hai

---

## 6️⃣ Checkout (Order Dena)

**URL:** http://localhost:8000/checkout  
**Login zaruri hai + Cart mein koi item hona chahiye**

**Form mein kya bharna hai:**
1. Full Name
2. Phone Number
3. Complete Address
4. City
5. Province
6. Postal Code

**"Place Order" click karne par:**
- ✅ Order database mein save hota hai
- ✅ Har plant ka **stock automatically minus** hota hai (ordered quantity ke hisaab se)
- ✅ Cart automatically **clear** ho jaati hai
- ✅ Order status **"Pending"** set hoti hai
- ✅ Customer ko success message aata hai
- ✅ Customer apne orders page par redirect hota hai

**Payment Method:** Cash on Delivery (COD) only

---

## 7️⃣ My Orders (Order History)

**URL:** http://localhost:8000/orders  
**Login zaruri hai**

**Kya dikh raha hoga:**
- Apne saare orders list mein
- Har order ka: Order ID, Date, Total Amount, Status
- Status colors: 🟡 Pending | 🔵 Processing | 🟢 Delivered

**Order Detail dekhna:**
- Kisi bhi order par click karo
- Items detail, shipping address, status sab dikh ga

---

## 8️⃣ Logout

- Top navigation bar mein "Logout" button
- Click karne par session clear hogi
- Home page par wapas aa jaoge

---
---

# 🔑 ADMIN SIDE — Complete Working

**Admin Login:** admin@florafetch.com / Admin@1234

**Security:**
- Customer admin pages access nahi kar sakta (403 error aayega)
- Bina login ke admin pages redirect to login

---

## 9️⃣ Admin Dashboard

**URL:** http://localhost:8000/admin/dashboard

**Kya dikh raha hai:**

| Stats Card | Kya show karta hai |
|------------|---------------------|
| Today's Orders | Aaj ke naye orders count |
| Pending Orders | Status "Pending" orders count |
| Total Plants | Inventory mein total plants |
| Low Stock Alerts | Stock < 5 wale plants count |
| Total Customers | Role = customer wale users count |

**Recent Orders Table:**
- Last 10 orders neeche table mein dikhti hain
- Customer name, amount, status sab dikh ta hai

---

## 🌿 Plant Management (Admin)

### 10️⃣ Saare Plants Dekhna

**URL:** http://localhost:8000/admin/plants

**Features:**
- Saare plants table mein (paginated — 15 per page)
- Search by name
- Filter by category
- Har plant ke saath Edit aur Delete buttons

---

### 1️⃣1️⃣ Naya Plant Add Karna

**URL:** http://localhost:8000/admin/plants/create

**Step by Step:**
1. Admin Dashboard ya Plants page par jao
2. **"Add New Plant"** button click karo
3. Form mein ye sab bharo:

| Field | Example | Rule |
|-------|---------|------|
| Plant Name | Aloe Vera | Required, max 150 chars |
| Category | Succulents | Required (Indoor/Outdoor/Succulents/Herbs) |
| Price (PKR) | 1250 | Required, must be number, min 0 |
| Sunlight Requirement | Full Sun | Required |
| Watering Need | Low | Required |
| Stock Quantity | 50 | Required, must be number, min 0 |
| Description | Good for indoor... | Optional |
| Plant Image | (image file) | Optional, JPG/PNG/WEBP, max 2MB |

4. **"Save Plant"** button click karo

**Save hone ke baad:**
- Plant inventory mein add ho jaata hai
- Admin Plants list mein wapas redirect hoga
- Success message dikh ga: `Plant "Aloe Vera" added to inventory.`
- Plant immediately Customer catalog mein show hone lagta hai

---

### 1️⃣2️⃣ Plant Edit Karna

**URL:** http://localhost:8000/admin/plants/{id}/edit

**Step by Step:**
1. Admin Plants page par jao
2. Jis plant ko edit karna hai uske saamne **"Edit"** button click karo
3. Pehle se bhari hui form khulegi
4. Jo bhi change karna ho — karo
5. Nayi image upload karo (optional — nahi karo toh purani rahegi)
6. **"Update Plant"** click karo

**Image update hone par:**
- Purani image automatically delete hoti hai storage se
- Nayi image save hoti hai

**Success message:** `Plant "Aloe Vera" updated.`

---

### 1️⃣3️⃣ Plant Delete Karna

**Step by Step:**
1. Admin Plants page par jao
2. Jis plant ko delete karna hai — **"Delete"** button click karo
3. Confirmation hogi
4. Plant delete ho jaayega

**Delete hone par:**
- Plant database se remove ho jaata hai
- Plant ki image bhi storage se delete ho jaati hai
- Customer catalog se immediately gayab ho jaata hai

---

## 📦 Order Management (Admin)

### 1️⃣4️⃣ Saare Orders Dekhna

**URL:** http://localhost:8000/admin/orders

**Features:**
- Saare customers ke orders ek jagah
- Latest orders pehle (paginated — 20 per page)

**Filter karna:**
- **Status se filter:** Pending / Processing / Delivered
- **Date se filter:** Kisi specific date ke orders

**Har order mein kya dikh ta hai:**
- Order ID
- Customer Name
- Total Amount (PKR)
- Current Status
- Order Date

---

### 1️⃣5️⃣ Order Status Update Karna

**Step by Step:**
1. Admin Orders page par jao
2. Kisi order ki status change karne ke liye dropdown use karo
3. Teen options hain:
   - 🟡 **Pending** — Naya order, abhi process nahi hua
   - 🔵 **Processing** — Order pack ho raha hai / dispatch ho raha hai
   - 🟢 **Delivered** — Order customer tak pahunch gaya

4. Status select karo → **"Update"** button click karo

**Update hone par:**
- Database mein status update hoti hai
- Customer apne Orders page par updated status dekh sakta hai
- Success message: `Order #5 status updated to Delivered.`

---
---

# 🔒 Security Features

| Feature | Kaise kaam karta hai |
|---------|----------------------|
| Password Hashing | Bcrypt se hash hoti hai — plain text nahi |
| Admin Protection | AdminMiddleware check karta hai — customer access nahi kar sakta |
| CSRF Protection | Har form mein hidden CSRF token hota hai |
| Auth Protection | Cart, Checkout, Orders — bina login ke nahi khulenge |
| DB Transaction | Order place hote waqt — ya pura hoga ya kuch nahi (data safe) |
| Input Validation | Har form server side validate hoti hai |
| Price Lock | Order place hone par price fix ho jaati hai — baad mein price change ho toh bhi affect nahi hoga |

---

# 📊 Database Tables

| Table | Kya store hota hai |
|-------|---------------------|
| users | Customer aur Admin accounts |
| plants | Plant inventory |
| orders | Customer orders |
| order_items | Har order ke individual plants |
| personal_access_tokens | Laravel Sanctum tokens |

---

# ⚠️ Important Rules & Limits

| Rule | Detail |
|------|--------|
| Cart quantity max | Plant ki stock quantity tak |
| Image size max | 2MB |
| Image format | JPG, JPEG, PNG, WEBP only |
| Password minimum | 8 characters + letters + numbers |
| Stock auto-deduct | Order place hote hi minus hota hai |
| Out of stock plants | Customer catalog mein nahi dikhte |

---

# 🚀 Project Chalane ke liye

```bash
# Terminal mein yeh command chalao:
cd C:\Users\DANI\Documents\xamp\htdocs\florafetch
C:\Users\DANI\Documents\xamp\php\php.exe artisan serve

# Phir browser mein jao:
http://localhost:8000
```

**XAMPP ka MySQL on hona zaruri hai!**

---

*FloraFetch — FYP Project | Plant E-Commerce Platform*
