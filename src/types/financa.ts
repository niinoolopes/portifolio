import { IGraficoBase, IPagination } from "./global";

// FINANCA
export type IFinanca = {
  panel?: number;
  carteira?: [IFNCT];
  grupo?: [IFNGP];
  categoria?: [IFNCG];
  situacao?: [IFNIS];
  tipo?: [IFNTP];
};

// CARTEIRA
export type IFNCT = {
  fnct_id: string | number;
  fnct_description: string;
  fnct_json: string;
  fnct_panel: number;
  fnct_enable?: number;
};

// GRUPO
export type IFNGP = {
  fngp_id: string | number;
  fngp_description: string;
  fngp_enable?: number;
  fngp_fechamento?: number;
  fnct_id: number;
  fnct?: IFNCT;
  fntp_id: number;
  fntp?: IFNTP;
};

// CATEGORIA
export type IFNCG = {
  fncg_id: string | number;
  fncg_description: string;
  fncg_obs: string;
  fncg_enable?: number;
  fncg_add_cofre?: number;
  fncg_fechamento?: number;
  fnct_id: number;
  fngp_id: number;
  fngp?: IFNGP;
  fntp_id?: number;
};

// TIPO
export type IFNTP = {
  fntp_id: string;
  fntp_description: string;
};

// SITUAÇÃO
export type IFNIS = {
  fnis_id: string;
  fnis_description: string;
};

// ITEM
export type IFNIT = {
  fnit_id: "new" | number;
  fnit_value: number | string;
  fnit_date: string;
  fnit_obs: string;
  fnit_enable: number;
  fnct_id: number;
  fnct?: IFNCT;
  fngp_id: number;
  fngp?: IFNGP;
  fncg_id: number;
  fncg?: IFNCG;
  fntp_id: number;
  fntp?: IFNTP;
  fnis_id: number;
  fnis?: IFNIS;
};

// ITEM DIVISAO
export type IFNDV = {
  id: number;
  name: string;
  fntp: number;
  divisao_percentual: number;
  divisao_total: number;
  divisao_compatible: boolean;
  percentual: number;
  total: number;
};

// ITEM CONSOLIDADO
export type IFNICItemList = {
  id: number;
  name: string;
  fntp: number;
  total: number;
  percentual: number;
  pago: number;
  pendente: number;
  talvez: number;
  divisao_total: number;
  divisao_percentual: number;
  divisao_compatible: false;
  fngp: number;
  fncg: number;
};

// ITEM ItemPop3
export type IItemsTop3 = {
  total: number;
  name: string;
};

// ITEM CONSOLIDATE
export type IConsolidadoItemComputed = {
  fncg: number;
  fngp: number;
  fntp: number;
  id: number;
  name: string;
  pago: number;
  pendente: number;
  percentual: number;
  talvez: number;
  total: number;
};
export type IFinancaConsolidadoItemMonth = {
  despesa: number;
  estimado: number;
  receita: number;
  sobra: number;
  fncg: IConsolidadoItemComputed[];
  fngp: IConsolidadoItemComputed[];
  fntp: IConsolidadoItemComputed[];
};

// CRUD - CARTEIRA
export type ICarteiraGelAllProps = {
  params?: string | "";
};
export type ICarteiraGetByIdProps = {
  fnct_id: number;
};
export type ICarteiraStoreProps = {
  body: IFNCT;
};
export type ICarteiraUpdateProps = {
  body: IFNCT;
  fnct_id: number;
};
export type ICarteiraDashboardProps = {
  fnct_id: number;
};
export type ICarteiraConsolidarProps = {
  fnct_id: number;
};

// CRUD - GRUPO
export type IGrupoGelAllProps = {
  params?: string | "";
};
export type IGrpoGetByIdProps = {
  fngp_id: number;
};
export type IGrpoStoreProps = {
  body: IFNGP;
};
export type IGrpoUpdateProps = {
  body: IFNGP;
  fngp_id: number;
};

// CRUD - CATEGORIA
export type ICategoriaGelAllProps = {
  params?: string | "";
};
export type ICategoriaGetByIdProps = {
  fncg_id: number;
};
export type ICategoriaStoreProps = {
  body: IFNCG;
};
export type ICategoriaUpdateProps = {
  body: IFNCG;
  fncg_id: number;
};

// FORM
export type IformSearchCarteira = IPagination & {
  fnct_enable: number;
  fnct_panel: number | string;
};
export type IformSearchGrupo = IPagination & {
  fntp_id: number;
  fngp_enable: number;
  fngp_fechamento: number | string;
  fnct_id: number | string;
};
export type IformSearchCategoria = IPagination & {
  fncg_enable: number;
  fncg_fechamento: number | string;
  fngp_id: number | string;
  fnct_id: number | string;
  fntp_id: number | string;
};
export type IformSearchExtrato = IPagination & {
  r: string;
  fntp_id: string;
  fngp_id: string;
  fncg_id: string;
  fnis_id: string;
  fnit_enable: number;
};
export type IformCarteira = {
  dataPage: IFNCT;
  isFetch: boolean;
  handleSubmit: any;
};
export type IformCarteiraConsolidar = {
  isFetch: boolean;
  handleConsoldar: any;
};
export type IformSearchAnaliseGrupoCategoria = {
  fntp_id: number;
  fngp_id: number;
  fncg_id: number;
};
export type IformSearchAnaliseAno = {
  fntp_id: number;
  fngp_id: number;
  fncg_id: number;
};

// SEARCH
export type ISearchItemProps = {
  form: IformSearchExtrato;
  set: any;
};
export type ISearchCarteiraProps = {
  form: IformSearchCarteira;
  set: any;
};
export type ISearchGrupoProps = {
  form: IformSearchGrupo;
  set: any;
};
export type ISearchCategoriaProps = {
  form: IformSearchCategoria;
  set: any;
};
export type ISearchAnaliseGrupoCategoriaProps = {
  form: IformSearchAnaliseGrupoCategoria;
  set: any;
};
export type ISearchAnaliseAnoProps = {
  form: IformSearchAnaliseAno;
  set: any;
};

// TABLE
export type ITableItemProps = {
  items?: IFNIT[];
  from: string;
};
export type ITableCarteiraProps = {
  items?: IFNCT[];
};
export type ITableGrupoProps = {
  items?: IFNGP[];
};
export type ITableCategoriaProps = {
  items?: IFNCG[];
};
export type ITableItemListConsolidadoProps = {
  items?: IConsolidadoItemComputed[];
};
export type ITableAnaliseGrupoCategoria = {
  isFetch: boolean;
  items: { name: string; value: number }[];
};
export type ITableAnaliseAno = {
  isFetch: boolean;
  items: [string | number][];
};

// GRAFICO
export type IGraficoDashboardPie = {
  labels: string[];
  values: number[];
  title: string;
};
export type IGraficoProps = {
  labels: string[];
  values: number[];
  title?: string;
};
export type IGeralAnoBar = {
  values: number[];
};

// COMPONENTS
export type ICardValues = {
  isFetch: boolean;
  values: {
    receita: number;
    despesa: number;
    sobra: number;
    estimado: number;
  };
};
export type ISaldo = {
  receita: number;
  despesa: number;
  sobra: number;
  estimado: number;
};
// CADS
export type ITap3Pops = {
  isFetch: boolean;
  item: IItemsTop3;
};

// PAGE
export type IPageDashboard = {
  saldo: ISaldo;
  fncgDespesaPie: IGraficoBase;
  fncgReceitaPie: IGraficoBase;
  fngpDespesaPie: IGraficoBase;
  fngpReceitaPie: IGraficoBase;
  fntpPie: IGraficoBase;
  saldoPie: IGraficoBase;
  fncgDespesaMax: IItemsTop3[];
  fncgReceitaMax: IItemsTop3[];
  fngpDespesaMax: IItemsTop3[];
  fngpReceitaMax: IItemsTop3[];
};
export type IPageAnaliseGrupoCategoria = {
  items: {
    items: IFNIT[];
    name: string;
  }[];
  valoresMes: {
    name: string;
    value: number;
  }[];
  valoresPie: IGraficoBase;
};
export type IPageAnaliseAno = {
  fntpAno: [string | number][];
  fngpAno: [string | number][];
  fncgAno: [string | number][];
};
export type IPageFechamento = {
  receita: number;
  despesa: number;
  sobra: number;
  fngp: any[];
  fncg: any[];

  fechamento: {
    grupo: IFNGP;
    grupos: IFNGP[];
  };
  retirada: {
    item: IFNIT;
    categoria: IFNCG;
    categorias: IFNCG[];
  };
  diferenca: {
    item: IFNIT;
    categoria: IFNCG;
    categorias: IFNCG[];
  };
  proxMes: {
    item: IFNIT;
    categoria: IFNCG;
    categorias: IFNCG[];
  };
};
export type IPageListaItem = {
  fnit_value: number;
  fnit_date: string;
  fnit_obs: "";
  fnit_enable: number;
  fnct_id: number;
  fngp_id: number;
  fngp?: IFNGP;
  fncg_id: number;
  fncg?: IFNCG;
  fntp_id: 1;
  fnis_id: 1;
  arrFngp: IFNGP[];
  arrFncg: IFNCG[];
};
export type IPageLista = {
  total: number;
  fnct_id: number;
  fntp_id: number;
  fnit_date: string;
};
export type IPageConsolidado = {
  saldo: {
    receita: number;
    despesa: number;
    sobra: number;
    estimado: number;
  };
  saldoPie: IGraficoBase;

  fntp: IConsolidadoItemComputed[];
  fntpPie: IGraficoBase;

  fngpReceita: IConsolidadoItemComputed[];
  fngpDespesa: IConsolidadoItemComputed[];
  fngpReceitaPie: IGraficoBase;
  fngpDespesaPie: IGraficoBase;

  fncgReceita: IConsolidadoItemComputed[];
  fncgDespesa: IConsolidadoItemComputed[];
  fncgReceitaPie: IGraficoBase;
  fncgDespesaPie: IGraficoBase;
};
