import React, { useCallback, useEffect } from 'react'
import Select from "../../form/Select"
import { ISearchAnaliseAnoProps, IformSearchAnaliseAno } from '../../../types/financa'
import OptionsTipo from '../../form/financa/OptionsTipo'
import { useContextFinanca } from '../../../context/financa'
import OptionsGrupo from '../../form/financa/OptionsGrupo'
import { useContextGlobal } from '../../../context/global'
import OptionsCategoria from '../../form/financa/OptionsCategoria'

export default function SearchAnaliseAno(props: ISearchAnaliseAnoProps) {
  const { dataFinanca } = useContextGlobal()
  const { getGrupo, getCategoria, setGrupo, setCategoria } = useContextFinanca()

  const handleField = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchAnaliseAno) => {
      const newObj = {
        ...obj,
        [key]: value
      }
      return newObj
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  useEffect(() => {
    setGrupo({ fnct_id: Number(dataFinanca.panel), fntp_id: props.form.fntp_id })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [dataFinanca])


  return (
    <section className="row g-2 pb-2 mb-2 shadow-sm">

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Tipo"
          name="fntp_id"
          onChange={({ target }: any) => {
            handleField('fngp_id', 0)
            handleField('fncg_id', 0)
            handleField('fntp_id', target.value)
            setGrupo({
              enable: 1,
              fntp_id: Number(target.value),
              fnct_id: Number(dataFinanca.panel)
            })
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
          onChange={({ target }: any) => {
            handleField('fncg_id', 0)
            handleField('fngp_id', target.value)
            setCategoria({
              enable: 1,
              fngp_id: Number(target.value),
              fnct_id: Number(dataFinanca.panel)
            })
          }}
          value={String(props.form.fngp_id)}
        >
          <OptionsGrupo items={getGrupo} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Categoria"
          name="fncg_id"
          onChange={({ target }: any) => {
            handleField('fncg_id', target.value)
          }}
          value={String(props.form.fncg_id)}
        >
          <OptionsCategoria items={getCategoria} />
        </Select>
      </div>

    </section>
  )
}
