import { useEffect, useState } from "react"
import { useContextFinanca } from "../context/financa"
import { useContextGlobal } from "../context/global"
import { dataAccordionInitial } from "../contextData/globals"
import { IAccordion } from "../types/global"
import Input from "../components/form/Input"
import Select from "../components/form/Select"
import { IFinanca } from "../types/financa"
import OptionsCarteira from "../components/form/financa/OptionsCarteira"
import { FaWallet } from "react-icons/fa"

export default function Accordion() {
  const { login, periodo, setPeriodo, setDataFinanca, dataFinanca } = useContextGlobal()
  const { getCarteira, setCarteiraPanel, setCarteira } = useContextFinanca()
  const [statusAccordion, setStatusAccordion] = useState<boolean>(false)
  const [dataAccordion, setDataAccordion] = useState<IAccordion>(dataAccordionInitial)

  useEffect(() => {
    if (login) {
      setCarteira({ enable: 1 })
      setCarteiraPanel()
    }
    setDataAccordion((obj: IAccordion) => {
      return {
        ...obj,
        menu: login,
        inputPeriodo: login && periodo,
        inputFinanca: login && dataFinanca.panel,
      }
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [login, dataFinanca])

  const handleSelectFinanca = (fnct_id: number) => {
    setDataFinanca((obj: IFinanca) => ({ ...obj, panel: fnct_id }))
    setCarteiraPanel()
  }


  return !login ? null
    : (
      <div className="accordion accordion-flush d-md-none mb-2">

        <div className="accordion-item">

          <h2 className="accordion-header" onClick={() => setStatusAccordion(!statusAccordion)}>
            <button className={`accordion-button py-2 ${!statusAccordion ? 'collapsed' : ''}`} type="button">
              <FaWallet />
            </button>
          </h2>

          <div id="flush-collapseOne" className={`accordion-collapse d-block border px-3 ${statusAccordion ? 'show border shadow-sm' : ''}`}>

            {!dataAccordion.inputPeriodo ? null :
              <>
                <Input
                  label="Periodo"
                  cssLabel="h6 mt-3 mb-1 p-0"
                  cssInput="mb-3"
                  name="periodo"
                  type="month"
                  value={periodo}
                  onChange={({ target }: any) => {
                    setPeriodo(target.value)
                    setTimeout(() => setStatusAccordion(false), 500)
                  }}
                />
              </>
            }

            {!dataAccordion.inputFinanca ? null :
              <>
                <Select
                  label="Carteira Finança"
                  cssLabel="h6 mb-1 p-0"
                  cssInput="mb-3a"
                  name="panel-fnct_id"
                  value={String(dataFinanca.panel)}
                  onChange={({ target }: any) => {
                    handleSelectFinanca(Number(target.value))
                    setTimeout(() => setStatusAccordion(false), 500)
                  }}
                  disabled={!dataFinanca.panel ? true : false}
                >
                  <OptionsCarteira optionEmpty={false} items={getCarteira} />
                </Select>
              </>
            }

          </div>
        </div>

      </div>
    )
}
