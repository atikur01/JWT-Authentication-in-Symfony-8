# 🚀 API Documentation

**Base URL**
```
http://127.0.0.1:8000
```

---

## 🔐 Authentication

### Login

**Endpoint**
```
POST /api/login_check
```

**Request Body**
```json
{
  "username": "user@test2.com",
  "password": "123456"
}
```

**Success Response**
```json
{
  "status": "success",
  "token": "ACCESS_TOKEN",
  "user": {
    "id": 1,
    "email": "user@test2.com"
  }
}
```

**Error Response**
```json
{
  "status": "error",
  "message": "Invalid credentials"
}
```

---

## 📝 Registration

### Register User

**Endpoint**
```
POST /api/register
```

**Request Body**
```json
{
  "email": "user@erfg2.com",
  "password": "123456"
}
```

**Success Response**
```json
{
  "status": "success",
  "message": "User registered successfully",
  "user": {
    "id": 2,
    "email": "user@erfg2.com"
  }
}
```

**Validation Error**
```json
{
  "status": "error",
  "errors": {
    "email": [
      "The email has already been taken."
    ]
  }
}
```

---

## 👤 Users

### Get User By ID

**Endpoint**
```
GET /api/users/{id}
```

**Example**
```
GET /api/users/1
```

**Headers**
```
Authorization: Bearer ACCESS_TOKEN
```

**Success Response**
```json
{
  "id": 1,
  "email": "user@test2.com",
  "created_at": "2025-01-01 10:00:00",
  "updated_at": "2025-01-01 10:00:00"
}
```

**Not Found**
```json
{
  "status": "error",
  "message": "User not found"
}
```

---

## 📌 Notes

- All APIs accept and return JSON
- Authorization via Bearer Token
- Password must be at least 6 characters
- Backend framework: Laravel

---

## 🧪 Testing Tools

- Postman
- Insomnia
- Curl

---

## 📬 Support

Contact backend developer for any API related issues.
