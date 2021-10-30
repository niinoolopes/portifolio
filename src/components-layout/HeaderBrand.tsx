import { useEffect, useState } from "react"
import { useContextGlobal } from "../context/global"
import useNavigate from "../hooks/useNavigate"
import { IHeaderBrand } from "../types/global"

export default function HeaderBrand(props: IHeaderBrand) {
  const { login } = useContextGlobal()
  const { urlNavigate } = useNavigate()
  const [url, setUrl] = useState<string>('/')

  const css = props.display === 'aside'
    ? 'd-none d-md-block'
    : 'd-md-none'

  useEffect(() => {
    setUrl(login ? '/dashboard' : '/')
  }, [login])

  return (
    <h3
      id="layout-header-brand"
      className={`text-center cursor-pointer m-0 ${css}`}
      onClick={() => urlNavigate(url)}
    >
      nn-crm
    </h3>
  )
}
