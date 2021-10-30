import React from 'react'
import useForm from '../../../hooks/useForm';
import { IformCarteiraConsolidar } from '../../../types/financa';
import Input from '../Input';

export default function FormCarteiraConsolidar(props: IformCarteiraConsolidar) {
  const {
    formRegister,
    formSubmit,
    formErrors,
  } = useForm();

  return (
    <form id="formConsolidar" onSubmit={formSubmit(props.handleConsoldar)}>
      <div className="row gx-2 gy-3">
        <div className="col-12 col-md-4 col-lg-3">
          <Input
            label="Periodo"
            type="month"
            disabled={props.isFetch}
            name="periodo"
            register={formRegister}
            error={formErrors.periodo}
          />
        </div>
      </div>
    </form>
  )
}
