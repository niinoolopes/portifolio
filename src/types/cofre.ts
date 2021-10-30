// CARTEIRA
export type ICOCT = {
  coct_id: string | number;
  coct_description?: string;
  coct_enable: number;
  coct_panel: number;
};
// TIPO
export type ICOTP = {
  cotp_id: String;
  cotp_value: String;
};
// ITEM
export type ICOIT = {
  coit_id: String | Number;
  coit_value: Number;
  coit_date: String;
  coit_obs: String;
  coit_porpuse: String;
  coit_enable: Number;
  coct?: ICOCT;
  coct_id: Number;
  cotp?: ICOTP;
  cotp_id: Number;
};
// PROPOSITO
export type IPurpose = {
  coit_porpuse: string;
};
// PAGE - Dashboard
export type IPorpuse = {
  origem: String;
  entrada: String;
  saida: String;
  saldo: String;
  percentual: String;
};
export type IPageDashboard = {
  saldo: {
    entrada: Number;
    saida: Number;
    saldo: Number;
  };
  porpuse: IPorpuse[];
};

// CRUD - CARTEIRA
export type ICarteiraGelAllProps = {
  params?: string | "";
};
export type ICarteiraGetByIdProps = {
  coct_id: number;
};
export type ICarteiraStoreProps = {
  body: ICOCT;
};
export type ICarteiraUpdateProps = {
  body: ICOCT;
  coct_id: number;
};
export type ICarteiraDashboardProps = {
  coct_id: number;
};
export type ICarteiraConsolidarProps = {
  coct_id: number;
};

// CRUD - ITEM
export type IItemGelAllProps = {
  params?: string | "";
};
export type IItemGetByIdProps = {
  coct_id: number;
  coit_id: number;
};
export type IItemStoreProps = {
  body: ICOIT;
  coct_id: number;
};
export type IItemUpdateProps = {
  body: ICOIT;
  coct_id: number;
  coit_id: number;
};
export type IItemDashboardProps = {
  coct_id: number;
};
export type IItemExtratoProps = {
  params?: string | "";
  coct_id: number;
};
export type IItemHistoricoProps = {
  params?: string | "";
  coct_id: number;
};
export type IItemPurposeProps = {
  coct_id: number;
};
