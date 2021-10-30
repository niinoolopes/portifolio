import React, { useCallback } from 'react'
import Select from "../../form/Select"
import OptionsStatus from '../../form/OptionsStatus'
import { ISearchCarteiraProps, IformSearchCarteira } from '../../../types/financa'
import OptionsPanel from '../../form/OptionsPanel'

export default function SearchCarteira(props: ISearchCarteiraProps) {

  const handleField = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchCarteira) => {
      const newObj = {
        ...obj,
        [key]: value
      }
      return newObj
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  return (
    <section className="row g-2 pb-2 mb-2 shadow-sm">

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Status"
          name="fnct_enable"
          onChange={({ target }: any) => handleField('fnct_enable', target.value)}
          value={String(props.form.fnct_enable)}
        >
          <OptionsStatus />
        </Select>
      </div>

      <div className="col-6 col-md-4 col-lg-3 col-xl-2">
        <Select
          label="Painel"
          name="fnct_panel"
          onChange={({ target }: any) => handleField('fnct_panel', target.value)}
          value={String(props.form.fnct_panel)}
        >
          <OptionsPanel />
        </Select>
      </div>

    </section>
  )
}
