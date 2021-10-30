import React, { useCallback, useContext, useEffect, useState } from 'react'
import { FaEdit, FaPlus } from 'react-icons/fa';
import { useNavigate } from 'react-router-dom';
import { GlobalContext } from '../../GlobalContext';
import useFetch from '../../hooks/useFetch';

function Lista() {
  const { baseUrl } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()

  const [users, setUsers] = useState([])
  const [usersList, setUsersList] = useState([])

  useEffect(async () => {
    const { status, data } = await request('get', `usuario`)
    if (status == 200) {
      setUsers(data)
      setUsersList(data.filter(el => el.usut_id == 1))
    }
  }, [request, setUsers])

  const handleUsersList = useCallback((usut_id) => {
    setUsersList(users.filter(el => el.usut_id == usut_id))
  }, [users, setUsersList])

  return (
    <div className="container py-3 px-2 p-md-4">
      <div className='card py-3 px-2 p-md-4 shadow-sm'>
        <h3 className="display-5 m-0 d-flex align-items-center justify-content-between">
          <span>Usuarios</span>
          <button type="button" className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2' onClick={() => navigate(`${baseUrl}usuario-novo`)}><FaPlus size="18px" /></button>
        </h3>
        <hr />

        <nav>
          <div className="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <a className="px-3 py-1 nav-item nav-link cursor-pointer active" data-toggle="tab" href="#nav-admin" onClick={() => handleUsersList(1)}>Administrador</a>
            <a className="px-3 py-1 nav-item nav-link cursor-pointer" data-toggle="tab" href="#nav-motorista" onClick={() => handleUsersList(2)}>Motorista</a>
            <a className="px-3 py-1 nav-item nav-link cursor-pointer" data-toggle="tab" href="#nav-cliente" onClick={() => handleUsersList(3)}>Cliente</a>
          </div>
        </nav>

        <div className="tab-content" id="nav-tabContent">
          <table className="table table-sm table-striped">
            <thead>
              <tr>
                <th className="border-top-0" width="40px"></th>
                <th className="border-top-0">Login</th>
                <th className="border-top-0">Nome</th>
                <th className="border-top-0">CPF/CNPJ</th>
                <th className="border-top-0">Email</th>
                <th className="border-top-0">Pix</th>
                <th className="border-top-0">Whatsapp</th>
                <th className="border-top-0">Status</th>
              </tr>
            </thead>
            <tbody>
              {usersList.map(el => (
                <tr key={el.usua_id}>
                  <td>
                    <div className="d-flex justify-content-center">
                      <div className="cursor-pointer inline-d-flex text-secondary" onClick={() => navigate(`${baseUrl}usuario/${el.usua_id}`)}><FaEdit /></div>
                    </div>
                  </td>
                  <td>{el.usua_login}</td>
                  <td>{el.usua_name}</td>
                  <td>{el.usua_cnpj}</td>
                  <td>{el.usua_email}</td>
                  <td>{el.usua_pix}</td>
                  <td>{el.usua_whatsapp}</td>
                  <td>{el.usua_status ? 'Ativo' : 'Inativo'}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  )
}

export default Lista
