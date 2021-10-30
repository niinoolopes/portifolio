import axios from "axios";
import { useCallback } from "react";
import { useContextGlobal } from "../context/global";
import { IRequest } from "../types/request";

const HOST =
  process.env.NODE_ENV === "development"
    ? process.env.REACT_APP_HOST_DEV
    : process.env.REACT_APP_HOST_PROD;

export default function useApi() {
  const { token, periodo } = useContextGlobal();

  const request = useCallback(
    async (props: IRequest) => {
      let _data = null;
      let _status = null;
      let _message = null;
      let _error = "";
      let url = "";

      let _current_page = 0;
      let _from = 0;
      let _last_page = 0;
      let _per_page = 0;
      let _to = 0;
      let _total = 0;

      try {
        if (props.p && props.p === true) {
          url += `?p=${periodo}`;
        }
        if (props.params) {
          url += `${props.p ? "&" : "?"}${props.params}`;
        }

        let config = {
          method: props.method,
          url: `${props.url}${url}`,
          data: props.body || {},
          baseURL: HOST,
          headers: {
            // "Access-Control-Allow-Origin": "*",
            "Content-Type": "application/json",
            Authorization: token ? `Bearer ${token}` : "",
            ...(props.headers || {})
          }
        };

        const response: any = await axios(config);

        _status = response.status;
        _data = response.data || null;
        _message = response.data.message || "";

        if (props.method === "GET") {
          _current_page = _data?.current_page || 0;
          _from = _data?.from || 0;
          _last_page = _data?.last_page || 0;
          _per_page = _data?.per_page || 0;
          _to = _data?.to || 0;
          _total = _data?.total || 0;
        }
      } catch (error) {
        let ErrorToString = `${Error}`.toString();

        if (ErrorToString === "function Error() { [native code] }") {
          _error = "Api não responde!";
        } else if (error.response.data) {
          _error = error.response.data.message;
        }
      } finally {
        return {
          status: _status,
          data: _data,
          message: _message,
          error: _error,

          current_page: _current_page,
          from: _from,
          last_page: _last_page,
          per_page: _per_page,
          to: _to,
          total: _total
        };
      }
    },
    [token, periodo]
  );

  return {
    request
  };
}

export const messages = {
  errors: {
    servidor: "Um error inesperado ocorreu!"
  },
  auth: {
    token: {
      sucess: "Token obtido!",
      error: "Ops, email ou senha inválidos!"
    },
    signIn: {
      sucess: "Bem Vindo!",
      error: "Erro ao obter dados do usuário!"
    }
  },
  financa: {
    analiseItem: {
      analiseGrupoCategoria: {
        sucess: "Analise encontrada!",
        error: "Erro ao buscar analise grupo/categoria!"
      },
      analiseAno: {
        sucess: "Analise ano encontrada!",
        error: "Erro ao buscar analise ano!"
      }
    },
    consolidadoItem: {
      consolidar: {
        sucess: "Items consolidados!",
        error: "Erro ao consolidar items!"
      },
      consolidadoItem: {
        sucess: "Dados consolidados encontrados!",
        error: "Dados consolidados não encontrados!"
      }
    },
    carteira: {
      get: {
        sucess: "Carteiras encontradas!",
        error: "Carteiras não encontradas!"
      },
      show: {
        sucess: "Carteira encontrada!",
        error: "Carteira não encontrada!"
      },
      store: {
        sucess: "Carteira criada!",
        error: "Erro ao criar carteira!"
      },
      update: {
        sucess: "Carteira atualizada!",
        error: "Erro ao atualizar carteira!"
      }
    },
    categoria: {
      get: {
        sucess: "Categorias encontradas!",
        error: "Categorias não encontradas!"
      },
      show: {
        sucess: "Categoria encontrada!",
        error: "Categoria não encontrada!"
      },
      store: {
        sucess: "Categoria criada!",
        error: "Erro ao criar categoria!"
      },
      update: {
        sucess: "Categoria atualizada!",
        error: "Erro ao atualizar categoria!"
      }
    },
    grupo: {
      get: {
        sucess: "Grupos encontrados!",
        error: "Grupos não encontrados!"
      },
      show: {
        sucess: "Grupo encontrado!",
        error: "Grupo não encontrado!"
      },
      store: {
        sucess: "Grupo criado!",
        error: "Erro ao criar grupo!"
      },
      update: {
        sucess: "Grupo atualizado!",
        error: "Erro ao atualizar grupo!"
      }
    },
    item: {
      get: {
        sucess: "Item(s) encontrados!",
        error: "Item(s) não encontrados!"
      },
      show: {
        sucess: "Item encontrado!",
        error: "Item não encontrado!"
      },
      store: {
        sucess: "Item criado!",
        error: "Erro ao criar item!"
      },
      update: {
        sucess: "Item atualizado!",
        error: "Erro ao atualizar item!"
      },
      delete: {
        sucess: "Item excluido!",
        error: "Erro ao excluir item!"
      }
    }
  },
  user: {
    update: {
      sucess: "Usuário atualizado!",
      error: "Erro ao atualizar usuário!"
    }
  }
};
