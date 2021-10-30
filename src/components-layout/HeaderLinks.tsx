import { FaCogs, FaSignInAlt } from 'react-icons/fa'
import { useContextGlobal } from '../context/global'
import useNavigate from '../hooks/useNavigate'

type RenderBtnProps = {
  url: string
  icon: any
}

export default function HeaderLinks() {
  const { login } = useContextGlobal()
  const { urlNavigate } = useNavigate()

  const links = [
    { icon: FaCogs, url: '/configuracao' },
    { icon: FaSignInAlt, url: '/' },
  ]

  return (
    <ul className="m-0 p-0 px-md-1">
      {login &&
        links.map(({ url, icon: Icon }: RenderBtnProps) => (
          <li
            onClick={() => urlNavigate(url)}
            className="btn btn-sm text-secondary shadow-none d-inline-flex justify-content-center"
            key={url}
          >
            <Icon size="21" />
          </li>
        ))}
    </ul>
  )
}
