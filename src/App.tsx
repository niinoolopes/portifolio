import 'bootstrap/dist/css/bootstrap.css'
import './styles/global.scss'

import { useEffect } from 'react';
import { useContextGlobal } from './context/global';
import useNavigate from './hooks/useNavigate';
import Aside from './components-layout/Aside';
import Content from './components-layout/Content';

function App() {
  const { urlNavigate } = useNavigate()
  const { login } = useContextGlobal()

  useEffect(() => {
    if (login === false) {
      urlNavigate('/')
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [login])


  return (
    <div id="layout" className="d-md-flex">
      <Aside />
      <Content />
    </div>
  );
}

export default App;
