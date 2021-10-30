import {
  FaCashRegister,
  FaChartBar,
  FaChartPie,
  FaHome,
  FaReceipt,
  FaTable
} from "react-icons/fa";
import { IRouterListItem } from "../types/global";

const routerItems: IRouterListItem[] = [
  {
    label: "Dashboard",
    url: "/dashboard",
    Icon: FaHome,
    key: "home",
    subItems: []
  },
  {
    label: "Finança",
    url: "/financa",
    Icon: FaChartPie,
    key: "financa",
    subItems: []
  },
  {
    label: "cadastrar",
    url: "/financa/item",
    Icon: FaCashRegister,
    parent: "financa",
    subItems: []
  },
  {
    label: "cadastrar lista",
    url: "/financa/item-lista",
    Icon: FaCashRegister,
    parent: "financa",
    subItems: []
  },
  {
    label: "Extrato",
    url: "/financa/extrato",
    Icon: FaReceipt,
    parent: "financa",
    subItems: []
  },
  {
    label: "Analise Grupo/Categoria",
    url: "/financa/analise/grupo-categoria",
    Icon: FaChartBar,
    parent: "financa",
    subItems: []
  },
  {
    label: "Analise ano",
    url: "/financa/analise/ano",
    Icon: FaChartBar,
    parent: "financa",
    subItems: []
  },
  {
    label: "Consolidado Mês",
    url: "/financa/consolidado-mes",
    Icon: FaTable,
    parent: "financa",
    subItems: []
  },
  {
    label: "Consolidado Ano",
    url: "/financa/consolidado-ano",
    Icon: FaTable,
    parent: "financa",
    subItems: []
  }
];

const subItems = routerItems.filter(el => el?.parent && !!el.parent);
const itemsParents = routerItems
  .filter(el => el?.key && !!el.key)
  .map(el => {
    el.subItems = subItems.filter(sub => sub.parent === el.key);
    return el;
  });

export const routerLinks: IRouterListItem[] = itemsParents;
export const routerFinancaLinks: IRouterListItem[] = [
  { ...itemsParents[1], label: "Dashboard" },
  ...itemsParents[1].subItems
];
