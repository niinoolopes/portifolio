import { IFNCG, IFNCT, IFNGP, IFNIT } from "./financa";
import { IUSUA } from "./global";

export type IRequest = {
  method: "GET" | "POST" | "PUT" | "DELETE";
  url: string;
  body?: any;
  p?: boolean | true;
  params?: string;
  headers?: {
    "Content-Type"?: string;
    Authorization: string;
  };
};

export type IGetTokenProps = {
  body: {
    email: string;
    password: string;
  };
};

export type ISignInProps = {
  headers: {
    Authorization: string;
  };
};

export type IUserUpdate = {
  body: IUSUA;
};

export type IFinancaCarteiraGet = {
  fnct_id?: number;
  params?: string;
};
export type IFinancaCarteiraStore = {
  body: IFNCT;
};
export type IFinancaCarteiraUpdate = {
  fnct_id: number;
  body: IFNCT;
};

export type IFinancaGrupoGet = {
  fngp_id?: number;
  params?: string;
};
export type IFinancaGrupoStore = {
  body: IFNGP;
};
export type IFinancaGrupoUpdate = {
  fngp_id: number;
  body: IFNGP;
};

export type IFinancaCategoriaGet = {
  fncg_id?: number;
  params?: string;
};
export type IFinancaCategoriaStore = {
  body: IFNCG;
};
export type IFinancaCategoriaUpdate = {
  fncg_id: number;
  body: IFNCG;
};

export type IFinancaItemGet = {
  fnct_id: number;
  fnit_id?: number;
  params?: string;
};
export type IFinancaItemStore = {
  fnct_id?: number;
  body: IFNIT;
};
export type IFinancaItemUpdate = {
  fnct_id: number;
  fnit_id: number;
  body: IFNIT;
};
export type IFinancaItemDelete = {
  fnct_id: number;
  fnit_id: number;
};

export type IFinancaConsolidar = {
  fnct_id: number;
  periodo?: string;
};
export type IFinancaConsolidadoItem = {
  type: "mes" | "ano";
  fnct_id: number;
};

export type IFinancaAnaliseItem = {
  fnct_id: number;
  fntp_id: number;
  fngp_id: number;
  fncg_id: number;
};
export type IFinancaAnaliseAno = {
  fnct_id: number;
  fntp_id?: number;
  fngp_id?: number;
  fncg_id?: number;
};
