export const baseMethodGet = async ({ request, url, setFetch, showAlert, msgSuccess, msgError, ...rest }) => {

  await setFetch(true);

  const response = await request({
    method: 'GET',
    url,
    ...rest
  });

  await setFetch(false);

  const status = response.status === 200;
  
  const showAlertDefault = !rest?.msgOnly || rest?.msgOnly === 'normal'
  const showAlertOk = rest?.msgOnly && rest?.msgOnly === 'ok' && response.status === 200
  const showAlertNoOk = rest?.msgOnly && rest?.msgOnly === 'error' && response.status === 204
  const showAlertError = rest?.msgOnly && rest?.msgOnly === 'error' && response.status >= 300


  if (showAlertDefault) {
    let alertMsg = ''
    if (response.status === 200) {
      alertMsg = msgSuccess
    } else if (response.status === 204) {
      alertMsg = 'Sem conteúdo'
    } else {
      alertMsg = msgError
    }

    const alertStatus = status ? "ok" : "error"
    await showAlert(alertStatus, [alertMsg]);
  }

  if (showAlertOk) {
    await showAlert('ok', [msgSuccess]);
  }
  if (showAlertNoOk) {
    await showAlert('error', ['Sem conteúdo']);
  }
  if (showAlertError) {
    await showAlert('error', [msgError]);
  }

  return {
    ...response,
    status
  };
}

export const baseMethodStrore = async ({ request, url, body, setFetch, showAlert, msgSuccess, msgError, ...rest }) => {

  await setFetch(true);

  const response = await request({
    method: 'POST',
    url,
    body,
    ...rest
  });

  await setFetch(false);

  const status = response.status === 201;

  const showAlertDefault = !rest?.msgOnly || rest?.msgOnly === 'normal'
  const showAlertOk = rest?.msgOnly && rest?.msgOnly === 'ok' && status
  const showAlertError = rest?.msgOnly && rest?.msgOnly === 'error' && !status

  if (showAlertDefault) {
    const alertStatus = status ? "ok" : "error"
    const alertMsg = status ? msgSuccess : msgError
    await showAlert(alertStatus, [alertMsg]);
  }
  if (showAlertOk) {
    await showAlert('ok', [msgSuccess]);
  }
  if (showAlertError) {
    await showAlert('error', [msgError]);
  }

  return {
    ...response,
    status
  };
}

export const baseMethodUpdate = async ({ request, url, body, setFetch, showAlert, msgSuccess, msgError }) => {

  await setFetch(true);

  const response = await request({
    method: 'PUT',
    url,
    body
  });

  await setFetch(false);

  const status = response.status === 201;

  const alertStatus = status ? "ok" : "error"
  const alertMsg = status ? msgSuccess : msgError
  await showAlert(alertStatus, [alertMsg]);

  return {
    ...response,
    status
  };
}

export const baseMethodDelete = async ({ request, url, setFetch, showAlert, msgSuccess, msgError }) => {

  await setFetch(true);

  const response = await request({
    method: 'DELETE',
    url,
  });

  await setFetch(false);

  const status = response.status === 204;

  const alertStatus = status ? "ok" : "error"
  const alertMsg = status ? msgSuccess : msgError
  await showAlert(alertStatus, [alertMsg]);

  return {
    ...response,
    status
  };
}