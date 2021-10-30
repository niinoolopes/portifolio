import React from 'react'
import useForm from '../../../hooks/useForm';
import { IformCarteira } from '../../../types/financa';
import Input from '../Input';
import OptionsPanel from '../OptionsPanel';
import OptionsStatus from '../OptionsStatus';
import Select from '../Select';

export default function FormCarteira(props: IformCarteira) {
  const {
    formRegister,
    formSubmit,
    formErrors,
    InputSelectRequired,
    InputTextRequired
  } = useForm();

  return (
    <form id="formCarteira" onSubmit={formSubmit(props.handleSubmit)}>
      <div className="row gx-2 gy-3">

        <div className="col-12 col-md-4 col-lg-3">
          <Input
            label="Descrição"
            placeholder="Digite uma descrição"
            type="text"
            disabled={props.isFetch}
            name="fnct_description"
            register={formRegister}
            options={InputTextRequired}
            error={formErrors.fnct_description}
            defaultValue={String(props.dataPage?.fnct_description)}
          />
        </div>

        <div className="col-12 col-md-4 col-lg-3">
          <Select
            label="Status"
            disabled={props.isFetch}
            name="fnct_enable"
            register={formRegister}
            options={InputSelectRequired}
            error={formErrors.fnct_enable}
            defaultValue={String(props.dataPage?.fnct_enable)}
          >
            <OptionsStatus />
          </Select>
        </div>

        <div className="col-12 col-md-4 col-lg-3">
          <Select
            label="Painel"
            disabled={props.isFetch}
            name="fnct_panel"
            register={formRegister}
            options={InputSelectRequired}
            error={formErrors.fnct_panel}
            defaultValue={String(props.dataPage?.fnct_panel)}
          >
            <OptionsPanel />
          </Select>
        </div>

      </div>
    </form>
  )
}
