import React, { useCallback, useContext } from 'react'
import { FaSave, FaTimes } from 'react-icons/fa'
import { GlobalContext } from '../GlobalContext'
import Input from './Input'
import Select from './Select'
import Textarea from './Textarea'

function ProdutoForm({ coleta, handleFormColetaProdutoType, modalColetaProduto, setModalColetaProduto, produtoTypes, produtoType, copt_id, colp_quantity, colp_price_unit, colp_price, colp_description }) {
  const { user } = useContext(GlobalContext)

  const toggleModal = useCallback((event) => {
    if (event.target == event.currentTarget) {
      setModalColetaProduto(false)
    }
  }, [setModalColetaProduto])

  return (
    <div className={`modal fade area-modal ${modalColetaProduto ? 'show d-block' : ''}`} onClick={toggleModal}>
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <div className="modal-body">
            <form onSubmit={handleFormColetaProdutoType}>
              <h3 className="display-5 m-0">{produtoType.colp_id == 'novo' ? 'Cadastro' : 'Edição'} de produto:</h3>
              <hr />

              <div className="d-flex flex-wrap ">
                <div className="px-2 col-6 col-md-3">
                  <Select label="Tipo de produto" name="copt_id" {...copt_id} disabled={!(user.usut_id == 1 || coleta.cols_id <= 3)} >
                    <option value="">Selecione ...</option>
                    {produtoTypes &&
                      produtoTypes.map(el => <option key={`produto-types-${el.copt_id}`} value={el.copt_id}>{el.copt_type}</option>)}
                  </Select>
                </div>
                <div className="px-2 col-6 col-md-3">
                  <Input label="Quantidade" type="number" name="colp_quantity" {...colp_quantity} disabled={!(user.usut_id == 1 || (coleta.cols_id == 2 && user.usut_id == 2))} />
                </div>
                <div className="px-2 col-6 col-md-3">
                  <Input label="Preço uni." type="number" name="colp_price_unit" {...colp_price_unit} disabled={user.usut_id != 1} />
                </div>
                <div className="px-2 col-6 col-md-3">
                  <Input label="Preço uni." type="number" name="colp_price" {...colp_price} disabled={user.usut_id != 1} />
                </div>
                <div className="px-2 col-12">
                  <Textarea label="Descrção." name="colp_description" {...colp_description} disabled={!(user.usut_id == 1 || coleta.cols_id <= 3)} />
                </div>
              </div>
            </form>
          </div>

          <div className="modal-footer py-2 px-3">
            <button type="submit" className='inline-d-flex align-items-center justify-content-center bg-transparent border border-secondary rounded text-muted py-1 px-2 m-0 mr-2' onClick={handleFormColetaProdutoType}><FaSave size="18px" /></button>
            <button className='inline-d-flex align-items-center justify-content-center bg-secondary border-0 border-secondary rounded text-white py-1 px-2 m-0' onClick={() => setModalColetaProduto(false)}><FaTimes size="18px" /></button>
          </div>
        </div>
      </div>
    </div>
  )
}

export default ProdutoForm
