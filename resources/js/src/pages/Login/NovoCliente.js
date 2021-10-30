import React, { useContext, useCallback, memo } from 'react'
import { Link, useNavigate } from 'react-router-dom';
import { GlobalContext } from '../../GlobalContext'
import Input from '../../components/Input';
import useFetch from '../../hooks/useFetch'
import useForm from '../../hooks/useForm';
import Select from '../../components/Select';

const Cadastro = () => {
  const { user, baseUrl, handleLogin } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()

  const usua_login = useForm({ v: true })
  const usua_password = useForm({ v: true })
  const usua_name = useForm({ v: true })
  const usua_email = useForm({ v: true })
  const usua_cnpj = useForm({ v: true })
  const usua_pix = useForm({ v: true })
  const usua_status = useForm({ v: true })
  const usua_whatsapp = useForm({ v: true, min: 9 })
  const usut_id = useForm({ v: true, val: 3 })

  const end_complement = useForm({ v: true })
  const end_address = useForm({ v: true })
  const end_number = useForm({ v: true })
  const end_district = useForm({ v: true })
  const end_city = useForm({ v: true })
  const end_zipcode = useForm({ v: true })

  const usua_agencia = useForm({ v: true })
  const usua_banco = useForm({ v: true })
  const usua_conta = useForm({ v: true })


  const handleForm = useCallback(async (event) => {
    event.preventDefault();

    const body = {
      usua_login: usua_login.value,
      usua_password: usua_password.value,
      usua_name: usua_name.value,
      usua_email: usua_email.value,
      usua_cnpj: usua_cnpj.value,
      usua_pix: usua_pix.value,
      usua_status: usua_status.value,
      usua_whatsapp: usua_whatsapp.value,
      usut_id: usut_id.value,

      end_complement: end_complement.value,
      end_address: end_address.value,
      end_number: end_number.value,
      end_district: end_district.value,
      end_city: end_city.value,
      end_zipcode: end_zipcode.value,

      usua_agencia: usua_agencia.value,
      usua_banco: usua_banco.value,
      usua_conta: usua_conta.value,
      status: 1,
    }

    console.log('body', body)

    
    if (
      usua_login.validate() && usua_password.validate() && usua_name.validate() && usua_email.validate() && usua_cnpj.validate() && usua_pix.validate() && usua_whatsapp.validate() &&
      end_complement.validate() && end_address.validate() && end_number.validate() && end_district.validate() && end_city.validate() && end_zipcode.validate() &&
      usua_agencia.validate() && usua_banco.validate() && usua_conta.validate()
    ) {
      const { status } = await request('post', 'usuario', body)

      if (status == 200) {
        if (user.usua_id) {
          navigate(`${baseUrl}usuario-lista`)

        } else {
          const { data } = await request('post', 'login', body)
          handleLogin(data)
          navigate(`${baseUrl}painel-cliente`)
        }
      }
    } else {
      console.log('erro ao validar')
    }
  }, [usua_login, usua_password, usua_name, usua_email, usua_cnpj, usua_pix, usua_status, usua_whatsapp,
    end_complement, end_address, end_number, end_district, end_city, end_zipcode,
    usua_agencia, usua_banco, usua_conta])


  return (
    <div className="container py-3 px-2 p-md-4">
      <form className='card py-3 px-2 p-md-4 shadow-sm' onSubmit={handleForm}>

        <h3 className="display-5 m-0">Cadastro</h3>
        <hr />

        <div className="d-flex flex-wrap">

          <h5 className="p-0 mb-3 col-12 border-bottom border-dark">Dados pessoais:</h5>
          <div className="px-2 col-12 col-md-6 col-lg-3">
            <Input label="Nome Completo" type="text" name="usua_name" {...usua_name} />
          </div>
          <div className="px-2 col-12 col-md-6 col-lg-3">
            <Input label="Email" type="email" name="usua_email" {...usua_email} />
          </div>
          <div className="px-2 col-12 col-md-4 col-lg-2">
            <Input label="CPF/CNPJ" type="text" name="usua_cnpj" {...usua_cnpj} />
          </div>
          <div className="px-2 col-12 col-md-4 col-lg-2">
            <Input label="Pix" type="text" name="usua_pix" {...usua_pix} />
          </div>
          <div className="px-2 col-12 col-md-4 col-lg-2">
            <Input label="Whatsapp" type="number" name="usua_whatsapp" {...usua_whatsapp} />
          </div>


          <h5 className="p-0 mb-3 col-12 border-bottom border-dark">Dados de acesso:</h5>
          {user.usua_id &&
            <div className="px-2 col-12 col-md-3">
              <Select label="Tipo de usuário" name="usut_id" {...usut_id}>
                <option value="">Selecione</option>
                <option value="1">Administrador</option>
                <option value="2">Motorista</option>
                <option value="3">Cliente</option>
              </Select>
            </div>
          }
          <div className="px-2 col-12 col-md-3">
            <Input label="login" type="text" name="usua_login" {...usua_login} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Senha" type="password" name="usua_password" {...usua_password} />
          </div>


          <h5 className="p-0 mb-3 col-12 border-bottom border-dark">Endereço:</h5>
          <div className="px-2 col-12 col-md-6">
            <Input label="Endereço" type="text" name="end_address" {...end_address} />
          </div>
          <div className="px-2 col-12 col-md-2">
            <Input label="Número" type="number" name="end_number" {...end_number} />
          </div>
          <div className="px-2 col-12 col-md-4">
            <Input label="Complemento" type="text" name="end_complement" {...end_complement} />
          </div>
          <div className="px-2 col-12 col-md-2">
            <Input label="CEP" type="text" name="end_zipcode" {...end_zipcode} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Bairro" type="text" name="end_district" {...end_district} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Cidade" type="text" name="end_city" {...end_city} />
          </div>


          <h5 className="p-0 mb-3 col-12 border-bottom border-dark">Dados de bancários:</h5>
          <div className="px-2 col-12 col-md-3">
            <Input label="Banco" type="text" name="usua_banco" {...usua_banco} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Agência" type="text" name="usua_agencia" {...usua_agencia} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Conta" type="text" name="usua_conta" {...usua_conta} />
          </div>
        </div>

        <hr className="mt-1" />

        <div>
          {loading
            ? <button className='btn btn-sm btn-success mr-2' disabled>Cadastrar</button>
            : <button className='btn btn-sm btn-success mr-2' onClick={handleForm}>Cadastrar</button>
          }
          {!user.usua_id &&
            < Link to={`${baseUrl}`}>
              <button className='btn btn-sm btn-outline-primary'>Fazer Login</button>
            </Link>
          }
        </div>

      </form>
    </div >
  )
}

export default memo(Cadastro)