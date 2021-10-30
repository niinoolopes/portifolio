import React, { useCallback, useContext, useEffect, useState } from 'react'
import { FaSave, FaTimes } from 'react-icons/fa'
import { useNavigate, useParams } from 'react-router'
import Input from '../../components/Input'
import Select from '../../components/Select'
import { GlobalContext } from '../../GlobalContext'
import useFetch from '../../hooks/useFetch'
import useForm from '../../hooks/useForm'

function Perfil() {
  const { baseUrl, user, setUser, setAlert } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const { user_id } = useParams()
  const navigate = useNavigate()

  const [dataUser, setDataUser] = useState(false)

  const usua_login = useForm({ v: true })
  const usua_password = useForm()
  const usua_name = useForm({ v: true })
  const usua_email = useForm({ v: true })
  const usua_cnpj = useForm({ v: true })
  const usua_pix = useForm({ v: true })
  const usua_whatsapp = useForm({ v: true, min: 9 })
  const usua_status = useForm({ v: true })
  const usut_id = useForm({ v: true })

  const end_complement = useForm({ v: true })
  const end_address = useForm({ v: true })
  const end_number = useForm({ v: true })
  const end_district = useForm({ v: true })
  const end_city = useForm({ v: true })
  const end_zipcode = useForm({ v: true })

  const usua_agencia = useForm({ v: true })
  const usua_banco = useForm({ v: true })
  const usua_conta = useForm({ v: true })


  useEffect(async () => {
    if (user_id) {
      const { data } = await request('get', `usuario/${user_id}`)
      setDataUser(data)
    } else {
      setDataUser(user)
    }
  }, [])

  useEffect(async () => {
    if (dataUser) {
      usua_login.setValue(dataUser.usua_login || '')
      usua_password.setValue(dataUser.usua_password || '')
      usua_name.setValue(dataUser.usua_name || '')
      usua_email.setValue(dataUser.usua_email || '')
      usua_cnpj.setValue(dataUser.usua_cnpj || '')
      usua_pix.setValue(dataUser.usua_pix || '')
      usua_status.setValue(dataUser.usua_status || '')
      usua_whatsapp.setValue(dataUser.usua_whatsapp || '')
      usut_id.setValue(dataUser.usut_id || '')

      end_complement.setValue(user.end && user.end.end_complement ? user.end.end_complement : '')
      end_address.setValue(user.end && user.end.end_address ? user.end.end_address : '')
      end_number.setValue(user.end && user.end.end_number ? user.end.end_number : '')
      end_district.setValue(user.end && user.end.end_district ? user.end.end_district : '')
      end_city.setValue(user.end && user.end.end_city ? user.end.end_city : '')
      end_zipcode.setValue(user.end && user.end.end_zipcode ? user.end.end_zipcode : '')

      usua_agencia.setValue(dataUser.usua_agencia || '')
      usua_banco.setValue(dataUser.usua_banco || '')
      usua_conta.setValue(dataUser.usua_conta || '')
    }
  }, [dataUser])

  const handleForm = useCallback(async (event) => {
    event.preventDefault();

    if (
      usua_login.validate() && usua_password.validate() && usua_name.validate() && usua_email.validate() && usua_cnpj.validate() && usua_pix.validate() && usua_whatsapp.validate() &&
      end_complement.validate() && end_address.validate() && end_number.validate() && end_district.validate() && end_city.validate() && end_zipcode.validate() &&
      usua_agencia.validate() && usua_banco.validate() && usua_conta.validate()
    ) {
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
      }

      if (usua_password.value) body.usua_password = usua_password.value

      const { status, message, data } = await request('PUT', `usuario/${dataUser.usua_id}`, body)

      if (status == 200) {
        setUser(data)
        setAlert({
          type: 'success',
          label: message
        })
      }
    }
  }, [usua_login, usua_password, usua_name, usua_email, usua_cnpj, usua_pix, usua_status, usua_whatsapp,
    end_complement, end_address, end_number, end_district, end_city, end_zipcode,
    usua_agencia, usua_banco, usua_conta])


  return (
    <div className="container py-3 px-2 p-md-4">
      <form className='card py-3 px-2 p-md-4 shadow-sm' onSubmit={handleForm}>

        <h3 className="display-5 m-0">Editar usuario</h3>
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


          <h5 className="p-0 mb-3 col-12 h, border-bottom border-dark">Dados de acesso:</h5>
          <div className="px-2 col-12 col-md-3">
            <Input label="login" type="text" name="usua_login" {...usua_login} />
          </div>
          <div className="px-2 col-12 col-md-3">
            <Input label="Senha" type="password" name="usua_password" {...usua_password} />
          </div>
          {user_id && user.usut_id != user_id && user.usut_id == 1 &&
            <div className="px-2 col-12 col-md-4 col-lg-2">
              <Select label="Status" name="usua_status" {...usua_status}>
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
              </Select>
            </div>}


          <h5 className="p-0 mb-3 col-12 border-bottom border-dark">Endereço:</h5>
          <div className="px-2 col-12 col-md-6">
            <Input label="Endereço" type="text" name="end_address" {...end_address} />
          </div>
          <div className="px-2 col-4 col-md-2">
            <Input label="Número" type="number" name="end_number" {...end_number} />
          </div>
          <div className="px-2 col-8 col-md-4">
            <Input label="Complemento" type="text" name="end_complement" {...end_complement} />
          </div>
          <div className="px-2 col-5 col-md-3">
            <Input label="CEP" type="text" name="end_zipcode" {...end_zipcode} />
          </div>
          <div className="px-2 col-7 col-md-3">
            <Input label="Bairro" type="text" name="end_district" {...end_district} />
          </div>
          <div className="px-2 col-3 col-md-3">
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

        <div className="d-flex justify-content-start align-items-center pt-2 pl-2">
          <button type="submit" className='inline-d-flex align-items-center justify-content-center bg-transparent border border-secondary rounded text-muted py-1 px-2 m-0 mr-2' onClick={(e) => handleForm(e)} disabled={loading ? true : false}><FaSave size="18px" /></button>
          <button type="button" className='inline-d-flex align-items-center justify-content-center bg-secondary border-0 border-secondary rounded text-white py-1 px-2 m-0' onClick={() => navigate(`${baseUrl}usuario-lista`)}><FaTimes size="18px" /></button>
        </div>

      </form>
    </div>
  )
}

export default Perfil
