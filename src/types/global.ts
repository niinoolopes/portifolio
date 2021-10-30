import { IconType } from "react-icons/lib";

// GERAIS
export type IALERT = {
  enable: boolean;
  title?: string;
  type?: "success" | "danger";
  messages: string[];
};
export type ICollection = {
  page: number;
  from: number;
  last_page: number;
  per_page: number;
  to: number;
  total: number;
};
export type ILoading = {
  isFetch: boolean;
};
export type IRouterListItem = {
  disabled?: boolean;
  Icon?: IconType;
  label?: string;
  url: string;
  key?: string;
  parent?: string;
  subItems: IRouterListItem[];
};
export type BreadcrumbItem = {
  label: string;
  url?: string | "";
  active?: boolean;
};

// LAYOUTS
export type IAside = {
  menu: boolean;
  inputPeriodo: boolean;
  inputFinanca: boolean;
  inputCofre: boolean;
  inputInvestimento: boolean;
};
export type IAccordion = {
  menu: boolean;
  inputPeriodo: boolean;
  inputFinanca: boolean;
  inputCofre: boolean;
  inputInvestimento: boolean;
};
export type INavbarProps = {
  links: "financa" | "cofre" | "investimento";
  active?: string;
};
export type IHeaderBrand = {
  display: "aside" | "header";
};

// USUARIO
export type IUSUA = {
  id: string;
  name: string;
  email: string;
  password?: string;
};

// PAGINATION
export type IPagination = {
  from: Number;
  to: Number;
  total: Number;
  per_page: Number;
  page: Number;
  last_page: Number;
};
export type IPaginationProps = IPagination & {
  set?: any;
};
export type IPaginationLink = {
  label: string;
  page: number;
  active: boolean;
};
export type IPaginationLinks = {
  links: IPaginationLink[];
  // btnPreview: boolean
  // btnNext: boolean
};

// PAGE
export type IPageDashboard = {
  financa: {
    saldo: {
      receita: number;
      despesa: number;
      sobra: number;
      estimado: number;
    };
    saldoPie: IGraficoBase;
    fntpPie: IGraficoBase;
    fngpReceitaPie: IGraficoBase;
    fngpDespesaPie: IGraficoBase;
  };
};

// GRAFICO
export type IGraficoBase = {
  label: string[];
  value: number[];
};
export type IGraficoProps = IGraficoBase & {
  title?: string;
  legend?: {
    display?: true | false;
    max?: number;
    position?: "top" | "left" | "right" | "bottom";
  };
};

// COMPONENTS
export type IAccordionProps = {
  children: any;
  title: string;
};
