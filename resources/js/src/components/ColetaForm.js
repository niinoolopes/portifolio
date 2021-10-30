import React, { useContext, useEffect } from 'react'
import { FaSave, FaTrash } from 'react-icons/fa'
import { GlobalContext } from '../GlobalContext'
import useFetch from '../hooks/useFetch'
import Input from './Input'
import Select from './Select'

function ColetaForm({ handleFormColeta, removeColeta, coleta, cole_date, cole_price, cols_id, motr_id, finc_id, users, end_address, end_number, end_complement, end_zipcode, end_district, end_city }) {
  const { request } = useFetch()
  const { user, statusColeta, setStatusColeta } = useContext(GlobalContext)

  useEffect(async () => {
    if (!statusColeta) {
      const resColetastatus = await request('get', `coleta/status`)
      if (resColetastatus.status == 200) {
        setStatusColeta(resColetastatus.data)
      }
    }
  }, [request, statusColeta, setStatusColeta])

  return (
    <section className="mb-3">
      <form onSubmit={handleFormColeta}>
        <div className="d-flex flex-wrap">
          <h4 className="p-0 mb-2 col-12 border-bottom border-dark d-flex align-items-center justify-content-between">
            <span>Dados da coleta:</span>

            {(user.usut_id == 1 || coleta.cols_id == 1) &&
              <div>
                <button type="submit" className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2'><FaSave size="17px" /></button>
                <button className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2' onClick={removeColeta}><FaTrash size="17px" /></button>
              </div>}
          </h4>

          <div className="px-2 col-12 col-md-4 col-lg-3">
            <Input label="Data de coleta" type="date" name="cole_date" {...cole_date} disabled={user.usut_id != 1 || (coleta.cols_id > 1 && user.usut_id != 1)} />
          </div>
          <div className="px-2 col-12 col-md-4 col-lg-3">
            <Input label="Preço total" type="number" name="cole_price" {...cole_price} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-12 col-md-4 col-lg-3">
            <Select label="Status da coleta" name="cols_id" {...cols_id} disabled={user.usut_id != 1} >
              <option value=''>Selecione</option>
              {statusColeta &&
                statusColeta.map(el => (
                  <option value={el.cols_id} key={`coleta-status-${el.cols_id}`}>{el.cols_name}</option>
                ))
              }
            </Select>
          </div>
          
          {coleta.cols_id > 1 &&
            <div className="px-2 col-12 col-md-4 col-lg-3">
              <Select label="Motorista" name="motr_id" {...motr_id} disabled={user.usut_id != 1}>
                <option value="">Selecione</option>
                {users &&
                  users.filter(el => el.usut_id == 2).map(el => (
                    <option value={el.usua_id} key={`mort-${el.usua_id}`}>{el.usua_name}</option>
                  ))
                }
              </Select>
            </div>
          }
          {coleta.cols_id >= 4 ?
            (
              <div className="px-2 col-12 col-md-4 col-lg-3">
                <Select label="Administrador" name="finc_id" {...finc_id} disabled={user.usut_id != 1}>
                  <option value="">Selecione</option>
                  {users &&
                    users.filter(el => el.usut_id == 1).map(el => (
                      <option value={el.usua_id} key={`finc-${el.usua_id}`}>{el.usua_name}</option>
                    ))
                  }
                </Select>
              </div>
            ) : (
              <div className="px-2 col-12 col-md-4 col-lg-3"></div>
            )
          }

          <h4 className="p-0 mb-2 col-12 border-bottom border-dark">Dados de endereço:</h4>
          {coleta.cols_id == 1 &&
            <small className="p-0 mb-2 col-12 font-weight-light">Confirme o endereço para coleta!</small>
          }
          <div className="px-2 col-12 col-md-6">
            <Input label="Endereço" type="text" name="end_address" {...end_address} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-4 col-md-2">
            <Input label="Número" type="number" name="end_number" {...end_number} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-8 col-md-4">
            <Input label="Complemento" type="text" name="end_complement" {...end_complement} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-5 col-md-3">
            <Input label="CEP" type="text" name="end_zipcode" {...end_zipcode} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-7 col-md-3">
            <Input label="Bairro" type="text" name="end_district" {...end_district} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-3 col-md-3">
            <Input label="Cidade" type="text" name="end_city" {...end_city} disabled={user.usut_id != 1} />
          </div>
          <div className="px-2 col-12 col-md-4 d-none d-md-block"></div>

        </div>
      </form>
    </section>
  )
}

export default ColetaForm
