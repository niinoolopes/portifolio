import React, { memo, useCallback, useContext, useEffect, useState } from 'react'
import { FaEdit, FaPlus, FaSave, FaTimes } from 'react-icons/fa';
import { useNavigate, useParams } from 'react-router-dom';
import Input from '../../components/Input';
import Select from '../../components/Select';
import { GlobalContext } from '../../GlobalContext';
import useFetch from '../../hooks/useFetch';
import useForm from '../../hooks/useForm';

function TipoProduto() {
  const { baseUrl, setAlert } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()
  const { copt_id } = useParams()

  const [produtoType, setProdutoType] = useState(false)
  const copt_type = useForm({ v: true })
  const copt_price = useForm({ v: true })
  const copt_status = useForm({ v: true })


  useEffect(async () => {
    if (copt_id) {
      const { data } = await request('get', `produto/${copt_id}`)
      setProdutoType(data)
    } else {
      setProdutoType({
        copt_id: 'novo',
        copt_type: '',
        copt_price: '',
        copt_status: 1,
      })
    }
  }, [setProdutoType])

  useEffect(async () => {
    if (produtoType) {
      copt_type.setValue(produtoType.copt_type || '')
      copt_price.setValue(produtoType.copt_price || '')
      copt_status.setValue(produtoType.copt_status)
    }
  }, [produtoType])


  const handleForm = useCallback(async (event) => {
    event.preventDefault()

    if (copt_type.validate() && copt_price.validate()) {

      const body = {
        copt_type: copt_type.value,
        copt_price: copt_price.value,
        copt_status: copt_status.value
      }

      console.log('body ', body)

      let resProdutoType = null

      if (produtoType.copt_id == 'novo') {
        resProdutoType = await request('post', `produto`, body)
      } else {
        resProdutoType = await request('put', `produto/${produtoType.copt_id}`, body)
      }

      const { status, message } = resProdutoType

      if (status == 200) {
        setAlert({
          type: 'success',
          label: message
        })
        navigate(`${baseUrl}tipo-produto-lista`)
      }
    }
  }, [request, setAlert, copt_type, copt_price, copt_status])


  return (
    <div className="container py-3 px-2 p-md-4">
      <form className='card py-3 px-2 p-md-4 shadow-sm' onSubmit={(e) => handleForm(e)}>

        <h3 className="display-5 m-0">Editar usuario</h3>
        <hr />

        <div className="d-flex flex-wrap">
          <div className="px-2 col-12 col-md-6 col-lg-3">
            <Input label="Nome Completo" type="text" name="copt_type" {...copt_type} />
          </div>
          <div className="px-2 col-12 col-md-6 col-lg-3">
            <Input label="Email" type="number" name="copt_price" {...copt_price} />
          </div>
          <Select label="Status" name="copt_status" {...copt_status} >
            <option value='1'>Ativo</option>
            <option value='0'>Inativo</option>
          </Select>
        </div>

        <div className="d-flex justify-content-start align-items-center pt-2 pl-2">
          <button type="submit" className='inline-d-flex align-items-center justify-content-center bg-transparent border border-secondary rounded text-muted py-1 px-2 m-0 mr-2' onClick={(e) => handleForm(e)} disabled={loading ? true : false}><FaSave size="18px" /></button>
          <button type="button" className='inline-d-flex align-items-center justify-content-center bg-secondary border-0 border-secondary rounded text-white py-1 px-2 m-0' onClick={() => navigate(`${baseUrl}tipo-produto-lista`)}><FaTimes size="18px" /></button>
        </div>
      </form>
    </div>
  )
}

export default memo(TipoProduto)
