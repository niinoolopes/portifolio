import React, { useCallback, useEffect } from 'react'
import Select from "../../form/Select"
import OptionsStatus from '../../form/OptionsStatus'
import { ISearchCategoriaProps, IformSearchCategoria } from '../../../types/financa'
import OptionsTipo from '../../form/financa/OptionsTipo'
import OptionsFechamento from '../../form/financa/OptionsFechamento'
import OptionsCarteira from '../../form/financa/OptionsCarteira'
import { useContextFinanca } from '../../../context/financa'
import OptionsGrupo from '../../form/financa/OptionsGrupo'

export default function SearchCategoria(props: ISearchCategoriaProps) {
  const { getGrupo, getCarteira, setCarteira, setGrupo } = useContextFinanca()

  const handleField = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchCategoria) => {
      const newObj = {
        ...obj,
        [key]: value
      }
      return newObj
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  useEffect(() => {
    setCarteira({ enable: 1 })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])


  return (
    <section className="row g-2 pb-2 mb-2 shadow-sm">

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Carteira"
          name="fnct_id"
          onChange={({ target }: any) => {
            handleField('fnct_id', target.value)
            setGrupo({ fnct_id: Number(target.value), fntp_id: Number(props.form.fngp_id) })
          }}
          value={String(props.form.fnct_id)}
        >
          <OptionsCarteira items={getCarteira} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Tipo"
          name="fntp_id"
          onChange={({ target }: any) => {
            handleField('fntp_id', target.value)
            setGrupo({ fntp_id: Number(target.value), fnct_id: Number(props.form.fnct_id) })
          }}
          value={String(props.form.fntp_id)}
        >
          <OptionsTipo />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Grupo"
          name="fngp_id"
          onChange={({ target }: any) => handleField('fngp_id', target.value)}
          value={String(props.form.fngp_id)}
        >
          <OptionsGrupo items={getGrupo} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Status"
          name="fncg_enable"
          onChange={({ target }: any) => handleField('fncg_enable', target.value)}
          value={String(props.form.fncg_enable)}
        >
          <OptionsStatus />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Fechamento"
          name="fncg_fechamento"
          onChange={({ target }: any) => handleField('fncg_fechamento', target.value)}
          value={String(props.form.fncg_fechamento)}
        >
          <OptionsFechamento />
        </Select>
      </div>

    </section>
  )
}
