import React, { useEffect, useState } from 'react'
import { FaPlus, FaRegTrashAlt, FaSave } from 'react-icons/fa'
import { useContextGlobal } from '../../context/global'
import ItemModel from '../../models/financa/ItemModel'
import { IFNCG, IFNCT, IFNGP, IFNIT, IFNTP, IPageLista, IPageListaItem } from '../../types/financa'
import { formFinancaCategoria, formFinancaGrupo, pageLista, pageListaItem } from '../../contextData/financa'
import Input from '../../components/form/Input'
import Select from '../../components/form/Select'
import useForm from '../../hooks/useForm'
import ContentSection from '../../components-layout/ContentSection'
import Breadcrumb from '../../components-layout/Breadcrumb'
import Navbar from '../../components/navabar/Navbar'

export default function Lista() {

  const { dataFinanca, periodo } = useContextGlobal()
  const fnct_id = Number(dataFinanca.panel);
  const { itemStore } = ItemModel()
  const { formRegister, formSubmit, formErrors, InputTextRequired, InputSelectRequired, isSubmitting } = useForm()
  const [FNGP, setFNGP] = useState<[IFNGP]>()
  const [dataLista, setDataLista] = useState<IPageLista>(() => {
    return {
      ...pageLista,
      fnct_id: fnct_id
    }
  })
  const [lista, setLista] = useState<IPageListaItem[]>([])

  const addList = () => {
    setLista(obj => {
      return [
        ...obj,
        {
          ...pageListaItem,
          fnct_id: 0,
          fngp_id: 0,
          fncg_id: 0,
          fntp_id: 1,
          fnis_id: 1,
          arrFngp: FNGP || [],
        }
      ]
    })
  }

  const removeList = (itemDelete: IPageListaItem) => {
    setLista(lista.filter(item => item !== itemDelete))
  }

  const handleFNCT = (fnct_id: Number) => {
    if (fnct_id > 0) {

      // atualiza data lista
      setDataLista(data => {
        data.fnct_id = Number(fnct_id)
        return { ...data }
      })

      // reset lista
      setLista([])
    }
  }

  const handleFNTP = (fntp_id: Number) => {
    if (fntp_id > 0 && dataLista.fnct_id > 0) {

      // filtra grupos com carteira selecionada
      let arrGrupo = dataFinanca.grupo.filter((el: IFNGP) => (el.fnct_id === dataLista.fnct_id && el.fntp_id === fntp_id) ? true : false)
      setFNGP(arrGrupo)

      // atualiza data lista
      setDataLista((data: IPageLista) => {
        return {
          ...data,
          fntp_id: Number(fntp_id)
        }
      })

      // atualiza lista com os grupos
      setLista((lista: IPageListaItem[]) => {
        lista.forEach((item, i) => {
          item.fngp = { ...formFinancaGrupo }
          item.fngp_id = 0
          item.arrFngp = [...arrGrupo]
          item.fncg = { ...formFinancaCategoria }
          item.fncg_id = 0
          item.arrFncg = []
          lista[i] = item
        })
        return [...lista]
      })

      // reset lista
      setLista([])
    }
  }

  const handleFNGP = (fngp_id: number, index: any) => {
    // filtra grupos com carteira selecionada
    let arrCategoria = dataFinanca.categoria.filter((el: IFNCG) => el.fngp_id === fngp_id)

    // atualiza lista com as categorias
    setLista(lista => {
      lista[index].fngp = dataFinanca.grupo.filter((el: IFNGP) => el.fngp_id === fngp_id)[0]
      lista[index].fngp_id = fngp_id
      lista[index].fncg_id = 0
      lista[index].arrFncg = [...arrCategoria]
      return [...lista]
    })
  }

  const handleFNCG = (value: number, index: any) => {
    if (value) {
      setLista(lista => {
        lista[index].fncg = dataFinanca.categoria.filter((el: IFNCG) => el.fncg_id === value)[0]
        lista[index].fncg_id = value
        return [...lista]
      })
    }
  }

  const handleVALUE = (value: number, index: any) => {
    if (value) {

      setLista(lista => {

        lista[index].fnit_value = value

        // soma total
        let newTotal = lista.reduce((soma, item) => {
          soma += item.fnit_value
          return soma
        }, 0)

        // atualiza data lista
        setDataLista(data => {
          return {
            ...data,
            total: +Number(newTotal).toFixed(2)
          }
        })

        return [...lista]
      })
    }
  }

  const handleSubmit = () => {
    lista.map(async (item) => {
      let obs = `${item.fngp?.fngp_description || 'GRUPO'}/${item.fncg?.fncg_description || 'CATEGORIA'}: ${Number(item.fnit_value).toFixed(2)} de ${Number(dataLista.total).toFixed(2)}`

      const body: IFNIT = {
        fnit_id: 'new',
        fnit_value: item.fnit_value,
        fnit_date: dataLista.fnit_date,
        fnit_obs: obs,
        fnit_enable: 1,
        fnct_id: dataLista.fnct_id,
        fngp_id: item.fngp_id,
        fncg_id: item.fncg_id,
        fntp_id: dataLista.fntp_id,
        fnis_id: item.fnis_id
      }
      const fnct_id = Number(dataLista.fnct_id)

      await itemStore({ body, fnct_id })
    })

    setLista([])
    setDataLista(pageLista)
  }

  useEffect(() => {
    setDataLista((el: any) => {

      // filtra grupos com carteira selecionada
      let arrGrupo = dataFinanca.grupo.filter((el: IFNGP) => (el.fnct_id === fnct_id && el.fntp_id === 2) ? true : false)
      setFNGP(arrGrupo)

      // atualiza lista com os grupos
      setLista(lista => {
        lista.forEach((item, i) => {
          item.fngp = { ...formFinancaGrupo }
          item.fngp_id = 0
          item.arrFngp = [...arrGrupo]
          item.fncg = { ...formFinancaCategoria }
          item.fncg_id = 0
          item.arrFncg = []
          lista[i] = item
        })

        el.fnct_id = fnct_id
        el.fntp_id = 2
        return [...lista]
      })

      return el
    })

    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [dataFinanca, periodo])

  return (
    <>
      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Lista item' },
        ]}
      />

      <Navbar active="Lista" links="financa" />

      <form id="formLista" onSubmit={formSubmit(handleSubmit)}>
        <ContentSection>
          <div className="row g-2">
            <div className="col-12 col-md-3 col-lg-2">
              <Input label="Total" name="total" type="number" step="0.01" value={String(dataLista.total)} disabled />
            </div>

            <div className="col-6 col-md-4 col-lg-2">
              <Select label="Carteira" name='fnct_id' register={formRegister} options={InputSelectRequired} error={formErrors.fnct_id} defaultValue={String(dataLista.fnct_id)}
                onChange={({ target }: any) => handleFNCT(Number(target.value))}
              >
                <option value="">Selecione ...</option>
                {dataFinanca.carteira?.map((el: IFNCT) => <option key={`option-fnct-${el.fnct_id}`} value={`${el.fnct_id}`}>{el.fnct_description}</option>)}
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-2">
              <Select label="Tipo" name='fntp_id' register={formRegister} options={InputSelectRequired} error={formErrors.fntp_id} defaultValue={String(dataLista.fntp_id)}
                onChange={({ target }: any) => handleFNTP(Number(target.value))}
              >
                <option value="">Selecione ...</option>
                {dataFinanca.tipo?.map((el: IFNTP) => <option key={`option-fntp-${el.fntp_id}`} value={`${el.fntp_id}`}>{el.fntp_description}</option>)}
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-2">
              <Input label="Data" name="fnit_date" type="date" register={formRegister} options={InputTextRequired} error={formErrors.fnit_date} defaultValue={dataLista.fnit_date}
                onChange={({ target }: any) => setDataLista((data: any) => ({ ...data, fnit_date: target.value }))} />
            </div>
          </div>
        </ContentSection>

        <ContentSection
          title="Lista"
          btns={(
            <>
              {lista.length > 0
                ? <button type="submit" className="btn btn-sm" form="formLista" disabled={isSubmitting}><FaSave /></button>
                : null
              }
              {dataLista.fnct_id && dataLista.fntp_id
                ? <button type="button" className="btn btn-sm" onClick={addList}><FaPlus /></button>
                : null
              }
            </>
          )}
        >
          <section className="container-table">
            <table>
              <thead>
                <tr>
                  <th></th>
                  <th style={{ minWidth: '125px' }}>Grupo</th>
                  <th style={{ minWidth: '150px' }}>Categoria</th>
                  <th className="text-center">Situação</th>
                  <th className="text-center">Valor</th>
                  <th style={{ minWidth: '250px' }}>Observação</th>
                </tr>
              </thead>
              <tbody>
                {lista.map((el: any, i) => (
                  <tr key={i}>
                    <td onClick={() => removeList(el)}>
                      <div
                        className="td-icons"
                      >
                        <span className="cursor-pointer">
                          <FaRegTrashAlt size="16" />
                        </span>
                      </div>
                    </td>

                    <td className="td-finc text-center">
                      <Select
                        cssLabel="m-0"
                        name={`${i}-fngp_id`}
                        register={formRegister}
                        options={InputSelectRequired}
                        error={formErrors[`${i}-fngp_id`]} defaultValue={el.fngp_id}
                        onChange={({ target }: any) => handleFNGP(Number(target.value), i)}
                      >
                        <option value="">Selecione ...</option>
                        {el.arrFngp?.map((el: IFNGP) => (
                          <option
                            key={`option-fngp-${el.fngp_id}`}
                            value={`${el.fngp_id}`}
                          >
                            {el.fngp_description}
                          </option>
                        ))}
                      </Select>
                    </td>

                    <td className="td-finc text-center">
                      <Select
                        name={`${i}-fncg_id`}
                        register={formRegister}
                        options={InputSelectRequired}
                        error={formErrors[`${i}-fncg_id`]}
                        defaultValue={el.fncg_id}
                        onChange={({ target }: any) => handleFNCG(Number(target.value), i)}
                      >
                        <option value="">Selecione ...</option>
                        {el.arrFncg?.map((el: IFNCG) => (
                          <option
                            key={`option-fncg-${el.fncg_id}`}
                            value={`${el.fncg_id}`}
                          >
                            {el.fncg_description}
                          </option>
                        ))}
                      </Select>
                    </td>

                    <td className="td-finc">
                      <Select
                        cssInput="text-center"
                        name={`${i}-fnis_id`}
                        register={formRegister}
                        options={InputSelectRequired}
                        error={formErrors[`${i}-fnis_id`]}
                        defaultValue={el.fnis_id}
                      >
                        <option value="">Selecione ...</option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Talvez</option>
                      </Select>
                    </td>

                    <td className="td-finc">
                      <Input
                        cssInput="text-center"
                        name={`${i}-fnit_value`}
                        type="number"
                        step="0.01"
                        register={formRegister}
                        options={InputTextRequired}
                        error={formErrors[`${i}-fnit_value`]}
                        defaultValue={el.fnit_value}
                        onChange={({ target }: any) => handleVALUE(Number(target.value), i)} />
                    </td>

                    <td className="">
                      <Input
                        cssInput="td-finc-obs"
                        name={`${i}-fnit_obs`}
                        type="text"
                        disabled={true}
                        value={`${el.fngp?.fngp_description || 'GRUPO'}/${el.fncg?.fncg_description || 'CATEGORIA'}: ${Number(el.fnit_value).toFixed(2)} de ${Number(dataLista.total).toFixed(2)}`} />
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </section>
        </ContentSection>
      </form>
    </>
  )
}