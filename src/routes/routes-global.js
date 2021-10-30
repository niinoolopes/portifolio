import { BrowserRouter, Route } from 'react-router-dom'

import Login from '../pages/Login'
import Dashboard from '../pages/Dashboard'
// import { Cofre } from '../pages/Cofre'
import FinancaDashboard from '../pages/Financa/Dashboard'
import FinancaItem from '../pages/Financa/Item'
import FinancaLista from '../pages/Financa/Lista'
import FinancaExtrato from '../pages/Financa/Extrato'
import FinancaConsolidadoMes from '../pages/Financa/ConsolidadoMes'
import FinancaConsolidadoAno from '../pages/Financa/ConsolidadoAno'
import FinancaAnaliseGrupoCategoria from '../pages/Financa/AnaliseGrupoCategoria'
import FinancaAnaliseAno from '../pages/Financa/AnaliseAno'
// import { Investimento } from '../pages/Investimento'
import Config from '../pages/Config'
import ConfigPerfil from '../pages/Config/Perfil'
import ConfigCofreCarteira from '../pages/Config/Cofre/Carteira'
// import ConfigCofreCarteiraId from '../pages/Config/Cofre/Carteira/id'
import ConfigFinancaCarteira from '../pages/Config/Financa/Carteira'
import ConfigFinancaCarteiraAdm from '../pages/Config/Financa/CarteiraAdm'
import ConfigFinancaGrupo from '../pages/Config/Financa/Grupo'
import ConfigFinancaGrupoAdm from '../pages/Config/Financa/GrupoAdm'
import ConfigFinancaCategoria from '../pages/Config/Financa/Categoria'
import ConfigFinancaCategoriaAdm from '../pages/Config/Financa/CategoriaAdm'
import ConfigInvestimentoCarteira from '../pages/Config/Investimento/Carteira'
// import ConfigInvestimentoCarteiraId from '../pages/Config/Investimento/Carteira/id'
import ConfigInvestimentoCorretora from '../pages/Config/Investimento/Corretora'
// import ConfigInvestimentoCorretoraId from '../pages/Config/Investimento/Corretora/id'
import ConfigInvestimentoAtivo from '../pages/Config/Investimento/Ativo'
// import ConfigInvestimentoAtivoId from '../pages/Config/Investimento/Ativo/id'
import ConfigInvestimentoAtivoTipo from '../pages/Config/Investimento/AtivoTipo'
// import ConfigInvestimentoAtivoTipoId from '../pages/Config/Investimento/AtivoTipo/id'

const listRouteGlobal = [
  //   // GERAL
  { path: '/', Element: Login },
  { path: '/dashboard', Element: Dashboard },
  //   { path: '/cofre*', Element: Cofre },
  { path: '/financa', Element: FinancaDashboard },
  { path: '/financa/item/:id?', Element: FinancaItem },
  { path: '/financa/item-lista', Element: FinancaLista },
  { path: '/financa/extrato', Element: FinancaExtrato },
  { path: '/financa/analise/grupo-categoria', Element: FinancaAnaliseGrupoCategoria },
  { path: '/financa/analise/ano', Element: FinancaAnaliseAno },
  { path: '/financa/consolidado-mes', Element: FinancaConsolidadoMes },
  { path: '/financa/consolidado-ano', Element: FinancaConsolidadoAno },
  //   { path: '/investimento*', Element: Investimento },

  //   // CONFIG
  { path: '/configuracao', Element: Config },
  { path: '/configuracao/perfil', Element: ConfigPerfil },
  { path: '/configuracao/cofre/carteira', Element: ConfigCofreCarteira },
  //   { path: '/configuracao/cofre/carteira/:id', Element: ConfigCofreCarteiraId },
  { path: '/configuracao/financa/carteira', Element: ConfigFinancaCarteira },
  { path: '/configuracao/financa/carteira/adm/:id?', Element: ConfigFinancaCarteiraAdm },
  { path: '/configuracao/financa/grupo', Element: ConfigFinancaGrupo },
  { path: '/configuracao/financa/grupo/adm/:id?', Element: ConfigFinancaGrupoAdm },
  { path: '/configuracao/financa/categoria', Element: ConfigFinancaCategoria },
  { path: '/configuracao/financa/categoria/adm/:id?', Element: ConfigFinancaCategoriaAdm },
  { path: '/configuracao/investimento/carteira', Element: ConfigInvestimentoCarteira },
  //   { path: '/configuracao/investimento/carteira/:id', Element: ConfigInvestimentoCarteiraId },
  { path: '/configuracao/investimento/corretora', Element: ConfigInvestimentoCorretora },
  //   { path: '/configuracao/investimento/corretora/:id', Element: ConfigInvestimentoCorretoraId },
  { path: '/configuracao/investimento/ativo', Element: ConfigInvestimentoAtivo },
  //   { path: '/configuracao/investimento/ativo/:id', Element: ConfigInvestimentoAtivoId },
  { path: '/configuracao/investimento/ativo-tipo', Element: ConfigInvestimentoAtivoTipo },
  //   { path: '/configuracao/investimento/ativo-tipo/:id', Element: ConfigInvestimentoAtivoTipoId },
]

// rota global
export const RoutesGlobal = () => {
  return (
    <>
      {listRouteGlobal.map(el => (
        <Route exact key={el.path} path={el.path} component={el.Element} />
      ))}
    </>
  )
}

// wrapper de rotas
export const RouterGlobal = ({ children }) => {
  return (
    <BrowserRouter
      basename="/nn-crm"
    >
      {children}
    </BrowserRouter>
  )
}