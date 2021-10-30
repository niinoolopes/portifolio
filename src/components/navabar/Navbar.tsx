import useNavigate from "../../hooks/useNavigate"
import { routerFinancaLinks } from "../../routes/links"
import { IRouterListItem, INavbarProps } from "../../types/global"


export default function Navbar(props: INavbarProps) {
  const { urlNavigate } = useNavigate()

  const navbarLink: {
    financa: IRouterListItem[],
    cofre: IRouterListItem[],
    investimento: IRouterListItem[],
  } = {
    financa: routerFinancaLinks,
    cofre: [],
    investimento: [],
  }

  return (
    <section id="layout-navbarContent">
      <nav className="pt-2">
        <ul className="nav nav-tabs flex-nowrap">
          {navbarLink[props.links] && navbarLink[props.links].map(item => (
            <li
              key={`navbar-li-${item.label}`}
              className={`nav-item cursor-pointer nav-link d-flex justify-content-center align-items-center p-1 ${props.active === item.label ? 'active text-dark' : 'text-black-50'}`}
              aria-current="page"
              onClick={() => urlNavigate(item.url)}
            >
              {/* className= */}
              {item.Icon ? <item.Icon size="22" className="d-block" /> : item.label}
            </li>
          ))}
        </ul>
      </nav>
    </section>
  )
}
