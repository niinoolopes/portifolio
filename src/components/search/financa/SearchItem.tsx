import React, { useCallback, useEffect } from 'react'
import Select from "../../form/Select"
import OptionsExtrato from "../../form/financa/OptionsExtrato"
import OptionsTipo from "../../form/financa/OptionsTipo"
import OptionsGrupo from '../../form/financa/OptionsGrupo'
import OptionsCategoria from '../../form/financa/OptionsCategoria'
import { useContextFinanca } from '../../../context/financa'
import OptionsStatus from '../../form/OptionsStatus'
import { ISearchItemProps, IformSearchExtrato } from '../../../types/financa'
import OptionsSituacao from '../../form/financa/OptionsSituacao'

export default function SearchItem(props: ISearchItemProps) {

  const { getCarteiraPanel, getGrupo, getCategoria, setGrupo, setCategoria } = useContextFinanca()

  const handleField = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchExtrato) => {
      const newObj = {
        ...obj,
        [key]: value
      }
      return newObj
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  useEffect(() => {
    setGrupo({ fnct_id: Number(getCarteiraPanel.fnct_id) })
    setCategoria({ fnct_id: Number(getCarteiraPanel.fnct_id) })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  return (
    <section className="row g-2 pb-2 mb-2 shadow-sm">

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Tipo de extrato"
          name="r"
          onChange={({ target }: any) => handleField('r', target.value)}
          value={props.form.r}
        >
          <OptionsExtrato />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Tipo"
          name="fntp_id"
          value={props.form.fntp_id}
          onChange={({ target }: any) => {
            handleField('fntp_id', target.value)
            handleField('fngp_id', 0)
            handleField('fncg_id', 0)
            setGrupo({ fnct_id: Number(getCarteiraPanel.fnct_id), fntp_id: Number(target.value) })
          }}
        >
          <OptionsTipo />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Grupo"
          name="fngp_id"
          value={props.form.fngp_id}
          onChange={({ target }: any) => {
            handleField('fngp_id', target.value)
            handleField('fncg_id', 0)
            setCategoria({ fnct_id: Number(getCarteiraPanel.fnct_id), fngp_id: Number(target.value) })
          }}
        >
          <OptionsGrupo items={getGrupo} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Categoria"
          name="fncg_id"
          onChange={({ target }: any) => handleField('fncg_id', target.value)}
          value={props.form.fncg_id}
        >
          <OptionsCategoria items={getCategoria} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Situação"
          name="fnis_id"
          onChange={({ target }: any) => handleField('fnis_id', target.value)}
          value={String(props.form.fnis_id)}
        >
          <OptionsSituacao />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Status"
          name="fnit_enable"
          onChange={({ target }: any) => handleField('fnit_enable', target.value)}
          value={String(props.form.fnit_enable)}
        >
          <OptionsStatus />
        </Select>
      </div>

    </section>
  )
}
