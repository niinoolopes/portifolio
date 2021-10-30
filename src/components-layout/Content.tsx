import { RoutesGlobal } from '../routes/routes-global'
import Header from '../components-layout/Header';
import Footer from '../components-layout/Footer';
import Alert from './Alert';
import Accordion from './Accordion';

export default function Content() {
  return (
    <div id="layout-content" className="col-md-10 d-flex flex-column bg-light position-relative">
      <Alert />
      <Header />
      <div id="layout-page" className="container-lg col py-3 px-md-3">
        <Accordion />
        <RoutesGlobal />
      </div>
      <Footer />
    </div>
  )
}
