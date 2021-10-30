import HeaderBrand from './HeaderBrand'
import HeaderLinks from './HeaderLinks'
import HeaderMenu from './HeaderMenu'

export default function Header() {

  return (
    <header id="layout-header" className="shadow-sm">
      <div className="container-lg d-flex justify-content-between justify-content-md-end align-items-center p-1 p-md-2 ">
        <HeaderMenu />

        <HeaderBrand display="header" />

        <HeaderLinks />
      </div>
    </header>
  )
}
