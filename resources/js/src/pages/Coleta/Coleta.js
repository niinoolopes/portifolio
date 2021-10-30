import React, { useCallback, useContext, useEffect, useState } from 'react'
import { useNavigate, useParams } from 'react-router'
import { GlobalContext } from '../../GlobalContext'
import useFetch from '../../hooks/useFetch'
import useForm from '../../hooks/useForm'
import ColetaForm from '../../components/ColetaForm'
import ColetaStatus from '../../components/ColetaStatus'
import ProdutoForm from '../../components/ProdutoForm'
import ProdutoTable from '../../components/ProdutoTable'
import { FaSync } from 'react-icons/fa'

function Coleta() {
  const { baseUrl, user, setAlert } = useContext(GlobalContext)
  const { cole_id } = useParams()
  const { loading, request } = useFetch()
  const [tabs, setTabs] = useState('ColetaForm')
  const [coleta, setColeta] = useState(false)
  const [coletaProduto, setColetaProduto] = useState(false)
  const [modalColetaProduto, setModalColetaProduto] = useState(false)
  const [produtoType, setProdutoType] = useState(false)
  const navigate = useNavigate()
  // listagens
  const [users, setUsers] = useState(false)
  const [produtoTypes, setProdutoTypes] = useState(false)
  // coleta
  const cole_date = useForm({ v: true })
  const cole_price = useForm({ v: true })
  const cole_status = useForm({ v: true })
  const motr_id = useForm({ v: true })
  const finc_id = useForm({ v: true })
  const cols_id = useForm({ v: true })
  // endereco
  const end_complement = useForm({ v: true })
  const end_address = useForm({ v: true })
  const end_number = useForm({ v: true })
  const end_district = useForm({ v: true })
  const end_city = useForm({ v: true })
  const end_zipcode = useForm({ v: true })
  // coleta produto
  const copt_id = useForm({ v: true })
  const colp_quantity = useForm({ v: true })
  const colp_price_unit = useForm({ v: true })
  const colp_price = useForm({ v: true })
  const colp_description = useForm({ v: true })


  useEffect(async () => {
    // coleta
    getColeta()
    // coleta produto
    getColetaProduto()
    // user
    const resUsers = await request('get', `usuario/list`)
    if (resUsers.status == 200) {
      setUsers(resUsers.data)
    }
    // produto type
    const resProdutoTypes = await request('get', `produto`)
    if (resProdutoTypes.status == 200) {
      setProdutoTypes(resProdutoTypes.data)
    }
  }, [])

  const getColeta = useCallback(async (dataColeta = false) => {

    let data = null

    if (!dataColeta) {
      const resColeta = await request('get', `coleta/${cole_id}`)
      data = resColeta.data
    } else {
      data = dataColeta
    }

    setColeta(data)

    cole_date.setValue(data.cole_date)
    cole_price.setValue(data.cole_price)
    cole_status.setValue(data.cole_status)
    motr_id.setValue(data.motr ? data.motr.usua_id : false)
    finc_id.setValue(data.finc ? data.finc.usua_id : false)
    cols_id.setValue(data.cols_id)

    end_complement.setValue(data.end ? data.end.end_complement : '')
    end_address.setValue(data.end ? data.end.end_address : '')
    end_number.setValue(data.end ? data.end.end_number : '')
    end_district.setValue(data.end ? data.end.end_district : '')
    end_city.setValue(data.end ? data.end.end_city : '')
    end_zipcode.setValue(data.end ? data.end.end_zipcode : '')
  }, [request, cole_id])

  const getColetaProduto = useCallback(async () => {
    const { data } = await request('get', `coleta/${cole_id}/product`)
    setColetaProduto(data)
  }, [request, cole_id])


  // FORM COLETA
  const handleFormColeta = useCallback(async (event) => {
    event.preventDefault()

    let resColeta = null

    if (
      cole_date.validate() &&
      cole_price.validate() &&
      cols_id.validate() &&
      motr_id.validate() &&
      finc_id.validate() &&
      end_address.validate() &&
      end_number.validate() &&
      end_complement.validate() &&
      end_zipcode.validate() &&
      end_district.validate() &&
      end_city.validate()
    ) {
      const body = {
        cole_date: cole_date.value,
        cole_price: cole_price.value,
        cols_id: cols_id.value,
        motr_id: motr_id.value,
        finc_id: finc_id.value,
        end_address: end_address.value,
        end_number: end_number.value,
        end_complement: end_complement.value,
        end_zipcode: end_zipcode.value,
        end_district: end_district.value,
        end_city: end_city.value
      }

      resColeta = await request('put', `coleta/${coleta.cole_id}`, body)

      if (resColeta.status == 200) {
        setAlert({
          type: 'success',
          label: resColeta.message
        })
      }
    }
  }, [request, setAlert, coleta, cole_date, cole_price, cols_id, motr_id, finc_id, end_address, end_number, end_complement, end_zipcode, end_district, end_city])

  // REMOVE COLETA
  const removeColeta = useCallback(async () => {
    if (confirm('Deseja mesmo excluir a coleta? os dados serão apagados permanentemente!')) {
      const { status, message } = await request('delete', `coleta/${coleta.cole_id}`)
      if (status == 200) {
        setAlert({
          type: 'success',
          label: message
        })
        if (user.usut_id === 1) navigate(`${baseUrl}painel-admin`)
        if (user.usut_id === 2) navigate(`${baseUrl}painel-motorista`)
        if (user.usut_id === 3) navigate(`${baseUrl}painel-cliente`)
      }
    }
  }, [request, setAlert, coleta, user])

  const syncPrice = useCallback(() => {
    const { status, data, message } = request('get', `coleta/${coleta.cole_id}/sync-price`)
    if (status == 200) {
      setColeta(data)
      setAlert({
        type: 'success',
        label: message
      })
    }
  }, [request, coleta])

  // FORM COLETA PRODUTO
  const handleFormColetaProdutoType = useCallback(async (event) => {
    event.preventDefault()

    let resProdutoType = null

    if (
      copt_id.validate() &&
      colp_description.validate()
    ) {
      const body = {
        copt_id: copt_id.value,
        colp_description: colp_description.value,
        colp_quantity: colp_quantity.value,
        colp_price_unit: colp_price_unit.value,
        colp_price: colp_price.value,
        colp_status: 1,
        cole_id: coleta.cole_id,
      }

      if (produtoType.colp_id == 'novo') {
        resProdutoType = await request('post', `coleta/${coleta.cole_id}/product`, body)
      } else {
        resProdutoType = await request('put', `coleta/${coleta.cole_id}/product/${produtoType.colp_id}`, body)
      }
      if (resProdutoType.status == 200) {
        setAlert({
          type: 'success',
          label: resProdutoType.message
        })
        getColetaProduto()
        setModalColetaProduto(false)
      }
    }
  }, [request, setAlert, getColetaProduto, coleta, produtoType, copt_id, colp_description, colp_quantity, colp_price_unit, colp_price])

  // ADM PRODUTO DA COLETA
  const admFormColetaProdutoType = useCallback(async (id = false) => {
    setModalColetaProduto(false)
    setProdutoType(false)

    let _colp_id = 'novo'
    let _colp_description = ''
    let _colp_quantity = 0
    let _colp_price_unit = 0
    let _colp_price = 0
    let _colp_status = 1
    let _cole_id = ''
    let _copt_id = ''

    if (id) {
      const resProduto = await request('get', `coleta/${coleta.cole_id}/product/${id}`)
      if (resProduto.status == 200) {
        _colp_id = resProduto.data.colp_id
        _colp_description = resProduto.data.colp_description
        _colp_quantity = resProduto.data.colp_quantity
        _colp_price_unit = resProduto.data.colp_price_unit
        _colp_price = resProduto.data.colp_price
        _colp_status = resProduto.data.colp_status
        _cole_id = resProduto.data.cole_id
        _copt_id = resProduto.data.copt_id
      }
    }

    setProdutoType({
      colp_id: _colp_id,
      colp_description: _colp_description,
      colp_quantity: _colp_quantity,
      colp_price_unit: _colp_price_unit,
      colp_price: _colp_price,
      colp_status: _colp_status,
      cole_id: _cole_id,
      _copt_id: _copt_id,
    })

    colp_description.setValue(_colp_description)
    colp_quantity.setValue(_colp_quantity)
    colp_price_unit.setValue(_colp_price_unit)
    colp_price.setValue(_colp_price)
    copt_id.setValue(_copt_id)

    setModalColetaProduto(true)

  }, [request, coleta, setProdutoType])

  // REMOVE PRODUTO DA COLETA
  const removeColetaProduto = useCallback(async (id) => {
    if (confirm('Deseja mesmo excluir o produto?')) {
      const { status, message } = await request('delete', `coleta/${coleta.cole_id}/product/${id}`)
      if (status == 200) {
        setAlert({
          type: 'success',
          label: message
        })
        getColetaProduto()
      }
    }
  }, [request, setAlert, getColetaProduto, coleta])



  return (
    <div className="container py-3 px-2 p-md-4">

      <div className='card py-3 px-2 p-md-4 shadow-sm mb-2' >
        <h3 className="display-5 m-0 d-flex align-items-center justify-content-between">
          <span>Coleta</span>
          {user.usut_id == 1 &&
            <button type="button" className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2 lead' onClick={syncPrice}>Atualiza preço coleta</button>}
        </h3>

        <hr />

        <nav>
          <div className="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <a className="px-3 py-1 nav-item nav-link cursor-pointer active" data-toggle="tab" onClick={() => setTabs('ColetaForm')}>Coleta</a>
            <a className="px-3 py-1 nav-item nav-link cursor-pointer" data-toggle="tab" onClick={() => setTabs('ProdutoForm')}>Produtos</a>
          </div>
        </nav>


        {tabs == 'ColetaForm' &&
          <>
            <ColetaForm
              handleFormColeta={handleFormColeta}
              removeColeta={removeColeta}
              coleta={coleta}
              cole_date={cole_date}
              cole_price={cole_price}
              cols_id={cols_id}
              motr_id={motr_id}
              finc_id={finc_id}
              users={users}
              end_address={end_address}
              end_number={end_number}
              end_complement={end_complement}
              end_zipcode={end_zipcode}
              end_district={end_district}
              end_city={end_city} />

            <ColetaStatus
              coleta={coleta}
              getColeta={getColeta}
              getColetaProduto={getColetaProduto} />

          </>
        }

        {tabs == 'ProdutoForm' &&
          <>
            {produtoType &&
              <ProdutoForm
                coleta={coleta}
                handleFormColetaProdutoType={handleFormColetaProdutoType}
                modalColetaProduto={modalColetaProduto}
                setModalColetaProduto={setModalColetaProduto}
                produtoTypes={produtoTypes}
                produtoType={produtoType}
                copt_id={copt_id}
                colp_quantity={colp_quantity}
                colp_price_unit={colp_price_unit}
                colp_price={colp_price} colp_description={colp_description} />}

            {coletaProduto &&
              <ProdutoTable
                coleta={coleta}
                coletaProduto={coletaProduto}
                admFormColetaProdutoType={admFormColetaProdutoType}
                removeColetaProduto={removeColetaProduto} />}
          </>
        }

      </div>
    </div >
  )
}

export default Coleta
