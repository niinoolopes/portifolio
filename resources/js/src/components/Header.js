import React, { useCallback } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { FaClipboard, FaHome, FaShippingFast, FaSignInAlt, FaUserCog, FaUsers } from 'react-icons/fa'
import './Header.css'
import { GlobalContext } from '../GlobalContext'

export default function Header() {
  const { baseUrl, user, login, handleLogout } = React.useContext(GlobalContext)
  const navigate = useNavigate()

  const onHome = useCallback(() => {
    if (user.usut_id === 1) navigate(`${baseUrl}painel-admin`)
    if (user.usut_id === 2) navigate(`${baseUrl}painel-motorista`)
    if (user.usut_id === 3) navigate(`${baseUrl}painel-cliente`)
  }, [user])

  const onLogout = useCallback(() => {
    handleLogout()
    navigate(`${baseUrl}`)
  }, [])

  return (
    <div className='shadow-sm border-bottom bg-white'>
      <div className="container d-flex align-items-center justify-content-between py-2">
        <nav className="d-flex align-items-center">
          <button className="navbar-brand text-dark border-0 bg-transparent" onClick={onHome}>Coletas</button>

          {login &&
            <nav className="nav">
              <button onClick={onHome} className="btn btn-sm bg-transparent py-0 icon-20"><FaHome /></button>

              {user.usut_id != 2 &&
                <button onClick={() => navigate(`${baseUrl}nova-coleta`)} className="btn btn-sm bg-transparent py-0 icon-20"><FaShippingFast /></button>}
            </nav>}
        </nav>

        {login &&
          <div className="d-flex align-items-center">
            <span className="font-weight-bold pt-1 mr-1">{user.usua_name} |</span>

            {user.usut_id == 1
              ?
              <>
                <Link to={`${baseUrl}usuario-lista`} className="btn btn-sm bg-transparent py-0 icon-20"><FaUsers size="26px" /></Link>
                <Link to={`${baseUrl}tipo-produto-lista`} className="btn btn-sm bg-transparent py-0 icon-20"><FaClipboard size="20px" /></Link>
              </>
              :
              <Link to={`${baseUrl}usuario`} className="btn btn-sm bg-transparent py-0 icon-20"><FaUserCog size="23px" /></Link>
            }
            <button className="btn btn-sm bg-transparent py-0 icon-20" onClick={onLogout}><FaSignInAlt size="22px" /></button>
          </div>
        }
      </div>
    </div>
  )
}
