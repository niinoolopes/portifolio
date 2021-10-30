import React, { memo, useCallback, useContext, useEffect, useState } from 'react'
import { GlobalContext } from '../GlobalContext'

import './Alert.css'

const Alert = () => {
  const { alert, setAlert } = useContext(GlobalContext)

  return (
    <div id="alert" className={`container ${alert && 'active'}`}>
      <div className={`m-0 shadow-sm alert alert-${alert.type == 'ok' ? 'success' : 'warning'}`}>

        {alert.type == 'ok' && <strong>Mensagem:! </strong>}
        {alert.type == 'error' && <strong>Atenção! </strong>}

        {alert.label}.

        <button type="button" className="close" onClick={() => setAlert(false)} >
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
    </div>
  )
}

export default memo(Alert)