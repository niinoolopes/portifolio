<h1>DOC API</h1>

# AUTH

## Auth/Login

> url.api/login

```
200 | POST

BODY:
  {
    email: '', password: ''
  }

PREVIEW:
  {
    "data": {
      "id": 1,
      "name": "nino teste",
      "email": "nino@nino.com"
    },
    "token": "11|FBEanGuiM4MbTybRz575ctVkYcE3A7b2Dlr7xAN5"
  }
```

## Auth/Logout

> url.api/logout

```
201 | POST

BODY:
  {
    email: '', password: ''
  }

PREVIEW:
  {
    "message": "success"
  }
```

# USER

> url.api/user

```
201 | PUT

BODY:
  {
    email: '', password: '', email: ''
  }

PREVIEW:
  {
    "id": 1,
    "name": "",
    "email": ""
  }
```

# CONFIG

## config/financa/carteira

> url.api/config/financa/carteira

```
200 | GET

PREVIEW:
  {
    "message": "Carteiras encontradas",
    "data": {
      "current_page": 1,
      "data": [],
      "per_page": 50,
      "total": 2
    }
  }
```

```
200 | GET/ID

PREVIEW:
  {
    "message": "Carteira encontrada",
    "data": {
      "fnct_id": 1,
      "fnct_description": "teste1",
      "fnct_json": {},
      "fnct_enable": 1,
      "fnct_panel": 1
    }
  }
```

```
201 | POST

BODY:
  {
    "fnct_description": "name"
  }

PREVIEW:
  {
    "message": "Carteira criada",
    "data": {
      "fnct_id": 3,
      "fnct_description": "teste3",
      "fnct_json": {},
      "fnct_enable": 1,
      "fnct_panel": 1
    }
  }
```

```
201 | PUT

BODY:
  {
    "fnct_description": "name"
  }

PREVIEW:
  {
    "message": "Carteira criada",
    "data": {
      "fnct_id": 3,
      "fnct_description": "teste3",
      "fnct_json": {},
      "fnct_enable": 1,
      "fnct_panel": 1
    }
  }
```

## config/financa/grupo

> url.api/config/financa/grupo

```
200 | GET

PREVIEW:
  {
    "message": "Grupos encontrados",
    "total": 1,
    "page": 1,
    "perPage": 15,
    "items": [
      {
        "fngp_id": 1,
        "fngp_description": "alimentacao",
        "fngp_enable": 1,
        "fngp_fechamento": 1,
        "fntp_id": 1,
        "fntp": {
          "fntp_id": 1,
          "fntp_description": "Receita"
        },
        "fnct_id": 1,
        "fnct": {
          "fnct_id": 1,
          "fnct_description": "Carteira 1",
          "fnct_enable": "1"
        }
      }
    ]
  }
```

```
200 | GET/ID

PREVIEW:
  {
    "message": "Grupo encontrado",
    "data": {
      "fngp_id": 1,
      "fngp_description": "alimentacao",
      "fngp_enable": 1,
      "fngp_fechamento": 0,
      "fntp_id": 1,
      "fntp": {
        "fntp_id": 1,
        "fntp_description": "Receita"
      },
      "fnct_id": 1,
      "fnct": {
        "fnct_id": 1,
        "fnct_description": "teste1",
        "fnct_enable": 1
      }
    }
  }
```

```
201 | POST

BODY:
  {
    "fngp_description":"alimentacao",
    "fngp_enable": 1,
    "fngp_fechamento": 0,
    "fntp_id": 1,
    "fnct_id": 1
  }

PREVIEW:
  {
    "message": "Grupo criado",
    "data": {
      "fngp_id": 1,
      "fngp_description": "alimentacao",
      "fngp_enable": 1,
      "fngp_fechamento": 0,
      "fntp_id": 1,
      "fntp": {
        "fntp_id": 1,
        "fntp_description": "Receita"
      },
      "fnct_id": 1,
      "fnct": {
        "fnct_id": 1,
        "fnct_description": "Carteira 1",
        "fnct_enable": "1"
      }
    }
  }
```

```
201 | PUT

BODY:
  {
    "fngp_description":"alimentacao",
    "fngp_enable": 1,
    "fngp_fechamento": 1,
    "fntp_id": 1,
    "fnct_id": 1
  }

PREVIEW:
  {
    "message": "Grupo atualizado",
    "data": {
      "fngp_id": 1,
      "fngp_description": "alimentacao",
      "fngp_enable": 1,
      "fngp_fechamento": 1,
      "fntp_id": 1,
      "fntp": {
        "fntp_id": 1,
        "fntp_description": "Receita"
      },
      "fnct_id": 1,
      "fnct": {
        "fnct_id": 1,
        "fnct_description": "Carteira 1",
        "fnct_enable": "1"
      }
    }
  }
```
