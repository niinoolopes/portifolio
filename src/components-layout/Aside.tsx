import { useEffect, useState } from "react";
import { useContextFinanca } from "../context/financa";
import { useContextGlobal } from "../context/global";
import useNavigate from "../hooks/useNavigate";
import { IFinanca } from "../types/financa";
import { IAside, IRouterListItem } from "../types/global";
import OptionsCarteira from "../components/form/financa/OptionsCarteira";
import Input from "../components/form/Input";
import Select from "../components/form/Select";
import Brand from "./HeaderBrand";
import { dataAsideInitial } from '../contextData/globals'
import { routerLinks } from "../routes/links";

export default function Aside() {
  const { login, periodo, setPeriodo, setDataFinanca, dataFinanca } = useContextGlobal()
  const { getCarteira, setCarteiraPanel, setCarteira } = useContextFinanca()
  const { urlNavigate } = useNavigate()
  const [dataAside, setDataAside] = useState<IAside>(dataAsideInitial)

  useEffect(() => {
    if (login) {
      setCarteira({ enable: 1 })
      setCarteiraPanel()
    }
    setDataAside((obj: IAside) => {
      return {
        ...obj,
        menu: login,
        inputPeriodo: login && periodo,
        inputFinanca: login && dataFinanca.panel,
        // inputCofre: boolean,
        // inputInvestimento: boolean,
      }
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [login, periodo, dataFinanca])


  const handleSelectFinanca = (fnct_id: number) => {
    setDataFinanca((obj: IFinanca) => ({ ...obj, panel: fnct_id }))
    setCarteiraPanel()
  }

  return (
    <div id="layout-aside" className="col-md-2 d-none d-md-block border-end bg-white">
      <div className="container d-flex justify-content-center align-items-center p-1 shadow-sm">
        <Brand display="aside" />
      </div>

      <section className="px-2 px-lg-3">
        {!dataAside.inputPeriodo ? null :
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
              }}
            />
          </>
        }

        {!dataAside.inputFinanca ? null :
          <>
            <Select
              label="Carteira Finança"
              cssLabel="h6 mb-1 p-0"
              cssInput="mb-3a"
              name="panel-fnct_id"
              value={String(dataFinanca.panel)}
              onChange={({ target }: any) => handleSelectFinanca(Number(target.value))}
              disabled={!dataFinanca.panel ? true : false}
            >
              <OptionsCarteira optionEmpty={false} items={getCarteira} />
            </Select>
          </>
        }

        {!login ? null :
          <>
            <hr />
          </>
        }
      </section>

      <ul className="px-2">
        {!login
          ? null
          : <>
            {
              routerLinks.map((item: IRouterListItem) => (
                <li key={`${item.label}-${item.url}`}>
                  <button
                    key={`${item.label}-${item.url}`}
                    className="d-flex align-items-center w-100 btn border-bottom text-body shadow-none text-start py-2"
                    onClick={() => urlNavigate(item.url)}
                  >
                    {item.Icon && <item.Icon size="18" className="text-black-50" />}
                    <span className="ms-2 text-truncate">{item.label}</span>
                  </button>

                  {item.subItems?.map((subItem: IRouterListItem) => (
                    <button
                      key={`${item.label}-${subItem.label}`}
                      className="d-flex align-items-center w-100 btn border-bottom text-body shadow-none text-start py-1"
                      onClick={() => urlNavigate(subItem.url)}
                    >
                      <span className="ms-1 text-truncate">- {subItem.label}</span>
                    </button>
                  ))}
                </li>
              ))
            }
          </>
        }
      </ul>
    </div>
  )
}
