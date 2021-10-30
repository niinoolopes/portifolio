import React, { useCallback, useEffect } from 'react'
import Select from "../../form/Select"
import OptionsStatus from '../../form/OptionsStatus'
import { ISearchGrupoProps, IformSearchGrupo } from '../../../types/financa'
import OptionsFechamento from '../../form/financa/OptionsFechamento'
import OptionsTipo from '../../form/financa/OptionsTipo'
import OptionsCarteira from '../../form/financa/OptionsCarteira'
import { useContextFinanca } from '../../../context/financa'

export default function SearchGrupo(props: ISearchGrupoProps) {
  const { getCarteira, setCarteira } = useContextFinanca()

  const handleField = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchGrupo) => {
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
          onChange={({ target }: any) => handleField('fnct_id', target.value)}
          value={String(props.form.fnct_id)}
        >
          <OptionsCarteira items={getCarteira} />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Tipo"
          name="fntp_id"
          onChange={({ target }: any) => handleField('fntp_id', target.value)}
          value={String(props.form.fntp_id)}
        >
          <OptionsTipo />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Status"
          name="fngp_enable"
          onChange={({ target }: any) => handleField('fngp_enable', target.value)}
          value={String(props.form.fngp_enable)}
        >
          <OptionsStatus />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Fechamento"
          name="fngp_fechamento"
          onChange={({ target }: any) => handleField('fngp_fechamento', target.value)}
          value={String(props.form.fngp_fechamento)}
        >
          <OptionsFechamento />
        </Select>
      </div>

    </section>
  )
}
