import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { GlobalContext } from './GlobalContext'

import Header from './components/Header';

import Login from './pages/Login';
import NovoCliente from './pages/Login/NovoCliente';
import NovaColeta from './pages/Coleta/NovaColeta';

import Coleta from './pages/Coleta/Coleta';

import Admin from './pages/PainelAdmin';
import Cliente from './pages/PainelCliente';
import Motorista from './pages/PainelMotorista';
import Alert from './components/Alert';
import Perfil from './pages/Perfil'
import PerfilLista from './pages/Perfil/Lista'
import TipoProduto from './pages/Produto/TipoProduto'
import TipoProdutoLista from './pages/Produto/TipoProdutoLista'

import bg from './../../../public/images/bg.png'
import './App.css'

export default function App() {
  const { baseUrl, setBaseUrl, setBaseApi } = React.useContext(GlobalContext)

  React.useEffect(() => {
    setBaseUrl(window.location.pathname)
    setBaseApi(`${window.location.href}api`)
  }, [])

  if (baseUrl === '') return <div>Carregando...</div>

  return (
    <BrowserRouter>

      <Header />

      <Alert />

      <div id="main" style={{ backgroundImage: `url(${baseUrl}public${bg})` }}>
        <Routes pathname={`${baseUrl}`}>
          <Route path={`${baseUrl}`} element={<Login />} />
          <Route path={`${baseUrl}nova-coleta`} element={<NovaColeta />} />
          <Route path={`${baseUrl}coleta/:cole_id`} element={<Coleta />} />

          <Route path={`${baseUrl}usuario-lista`} element={<PerfilLista />} />
          <Route path={`${baseUrl}usuario-novo`} element={<NovoCliente />} />
          <Route path={`${baseUrl}usuario/:user_id`} element={<Perfil />} />
          <Route path={`${baseUrl}usuario`} element={<Perfil />} />

          <Route path={`${baseUrl}painel-admin`} element={<Admin />} />
          <Route path={`${baseUrl}painel-cliente`} element={<Cliente />} />
          <Route path={`${baseUrl}painel-motorista`} element={<Motorista />} />

          <Route path={`${baseUrl}tipo-produto-lista`} element={<TipoProdutoLista />} />
          <Route path={`${baseUrl}tipo-produto-novo`} element={<TipoProduto />} />
          <Route path={`${baseUrl}tipo-produto/:copt_id`} element={<TipoProduto />} />
        </Routes>
      </div>

    </BrowserRouter>
  )
}
