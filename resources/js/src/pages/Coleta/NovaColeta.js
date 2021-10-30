import React, { useEffect, useContext, useCallback, memo, useState } from 'react'
import { useNavigate } from 'react-router-dom';
import { GlobalContext } from '../../GlobalContext'
import Input from '../../components/Input';
import useFetch from '../../hooks/useFetch'
import useForm from '../../hooks/useForm';
import Select from '../../components/Select';

const NovaColeta = () => {
  const { user, baseUrl } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()
  const [customers, setCustomers] = useState(false)
  const customer_id = useForm({ v: true })

  const cole_date = useForm({ v: true })
  const end_complement = useForm({ v: true })
  const end_address = useForm({ v: true })
  const end_number = useForm({ v: true })
  const end_district = useForm({ v: true })
  const end_city = useForm({ v: true })
  const end_zipcode = useForm({ v: true })



  useEffect(async () => {
    const d = new Date()
    let day = (d.getDate()).toString()
    let month = (d.getMonth() + 1).toString()
    let year = d.getFullYear()

    day = day.length == 1 ? `0${day}` : day
    month = month.length == 1 ? `0${month}` : month

    cole_date.setValue(`${year}-${month}-${day}`)
    end_complement.setValue(user.end && user.end.end_complement ? user.end.end_complement : '')
    end_address.setValue(user.end && user.end.end_address ? user.end.end_address : '')
    end_number.setValue(user.end && user.end.end_number ? user.end.end_number : '')
    end_district.setValue(user.end && user.end.end_district ? user.end.end_district : '')
    end_city.setValue(user.end && user.end.end_city ? user.end.end_city : '')
    end_zipcode.setValue(user.end && user.end.end_zipcode ? user.end.end_zipcode : '')

    // 

    if (user.usut_id == 1) {
      const { status, data } = await request('get', `usuario/customers`)
      if (status == 200) {
        setCustomers(data)
      }
    }
  }, [request, user])


  useEffect(() => {
    if (customers) {
      let _end_complement = ''
      let _end_address = ''
      let _end_number = ''
      let _end_district = ''
      let _end_city = ''
      let _end_zipcode = ''

      if (customer_id.value) {
        let customerSelected = customers.filter(el => el.usua_id == customer_id.value)

        if (customerSelected.length) {
          let customer = customerSelected[0]

          _end_complement = customer.end && customer.end.end_complement ? customer.end.end_complement : ''
          _end_address = customer.end && customer.end.end_address ? customer.end.end_address : ''
          _end_number = customer.end && customer.end.end_number ? customer.end.end_number : ''
          _end_district = customer.end && customer.end.end_district ? customer.end.end_district : ''
          _end_city = customer.end && customer.end.end_city ? customer.end.end_city : ''
          _end_zipcode = customer.end && customer.end.end_zipcode ? customer.end.end_zipcode : ''
        }
      }
      end_complement.setValue(_end_complement)
      end_address.setValue(_end_address)
      end_number.setValue(_end_number)
      end_district.setValue(_end_district)
      end_city.setValue(_end_city)
      end_zipcode.setValue(_end_zipcode)
    }
  }, [customer_id, customers])

  const handleForm = useCallback(async (event) => {
    event.preventDefault();

    if (
      cole_date.validate() &&
      end_complement.validate() &&
      end_address.validate() &&
      end_number.validate() &&
      end_district.validate() &&
      end_city.validate() &&
      end_zipcode.validate()
    ) {
      const body = {
        clie_id: customer_id.value || user.usua_id,
        cole_date: cole_date.value,
        end_complement: end_complement.value,
        end_address: end_address.value,
        end_number: end_number.value,
        end_district: end_district.value,
        end_city: end_city.value,
        end_zipcode: end_zipcode.value,
      }

      const { status, data } = await request('post', 'coleta', body)
      if (status == 200) {
        navigate(`${baseUrl}coleta/${data.cole_id}`)
      }
    }
  }, [request, cole_date, end_complement, end_address, end_number, end_district, end_city, end_zipcode])



  return (
    <div className="container py-3 px-2 p-md-4">
      <form className='card py-3 px-2 p-md-4 shadow-sm' onSubmit={handleForm}>

        <h3 className="display-5 m-0">Nova Coleta</h3>
        <hr />

        <div className="d-flex flex-wrap">

          <h5 className="p-0 mb-2 col-12 border-bottom border-dark">Dados da coleta:</h5>

          {user.usut_id == 1 &&
            <div className="px-2 col-12 col-md-4 col-lg-3">
              <Select label="Cliente" name="customer_id" {...customer_id}>
                <option value="">Selecione</option>
                {customers &&
                  customers.map(el => (
                    <option value={el.usua_id} key={`customers-${el.usua_id}`}>{el.usua_name}</option>
                  ))
                }
              </Select>
            </div>
          }

          <div className="px-2 col-12 col-md-4 col-lg-3">
            <Input label="Data de coleta" type="date" name="cole_date" {...cole_date} />
          </div>

          <h5 className="p-0 mb-0 col-12 border-bottom border-dark">Dados de endereço:</h5>
          <small className="p-0 mb-2 col-12 font-weight-light">Confirme o endereço para coleta!</small>
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
          <div className="px-2 col-12 col-md-4 d-none d-md-block"></div>

        </div>

        <hr className="mt-1" />

        <div>
          <button className='btn btn-sm btn-primary' onClick={handleForm}>Enviar</button>
        </div>
      </form>
    </div>
  )
}

export default memo(NovaColeta)