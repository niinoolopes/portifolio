import React, { useCallback, useContext, memo } from 'react'
import { Link, useNavigate } from 'react-router-dom';
import { GlobalContext } from '../../GlobalContext'
import Input from '../../components/Input';
import useFetch from '../../hooks/useFetch'
import useForm from '../../hooks/useForm';

const Login = () => {
  const { baseUrl, handleLogin, setStatusColeta } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()


  const usua_login = useForm({ v: true, min: 4, val: '' })
  const usua_password = useForm({ v: true, min: 4, val: '' })
  // const usua_login = useForm({ v: true, min: 4, val: 'cliente1' })
  // const usua_password = useForm({ v: true, min: 4, val: 'teste' })


  const handleForm = useCallback(async (event) => {
    event.preventDefault();

    if (usua_login.validate() && usua_password.validate()) {

      const body = {
        usua_login: usua_login.value,
        usua_password: usua_password.value
      }

      const resLogin = await request('post', 'login', body)
      if (resLogin.status == 200) {

        handleLogin(resLogin.data)

        if (resLogin.data.user.usut_id === 1) navigate(`${baseUrl}painel-admin`)
        if (resLogin.data.user.usut_id === 2) navigate(`${baseUrl}painel-motorista`)
        if (resLogin.data.user.usut_id === 3) navigate(`${baseUrl}painel-cliente`)
      }

    }
  }, [usua_login, usua_password])

  return (
    <div className="container mt-5 d-flex justify-content-center align-items-center">
      <form className='col-md-8 col-lg-5 py-3 px-2 p-md-4 card shadow-sm' onSubmit={handleForm}>

        <h3 className="display-5 m-0">Login</h3>
        <hr />

        <Input label="Login" type="text" name="usua_login" {...usua_login} />
        <Input label="Senha" type="password" name="usua_password" {...usua_password} />

        <hr className="mt-1" />

        <div>
          {loading
            ? <button className='btn btn-sm btn-primary mr-2' disabled>Entrar</button>
            : <button className='btn btn-sm btn-primary mr-2' onClick={handleForm}>Entrar</button>
          }
          <Link to={`${baseUrl}usuario-novo`}>
            <button className='btn btn-sm btn-outline-success'>Fazer Cadastro</button>
          </Link>
        </div>
      </form>
    </div>
  )
}

export default memo(Login)