import { FaSave } from "react-icons/fa";
import Input from "../../../components/form/Input";
import Breadcrumb from "../../../components-layout/Breadcrumb";
import { useContextGlobal } from "../../../context/global";
import useForm from "../../../hooks/useForm";
import { IUSUA } from "../../../types/global";
import UserModel from '../../../models/UserModel'
import ContentSection from "../../../components-layout/ContentSection";
import LoadingPage from "../../../components/loading/LoadingPage";

export default function Perfil() {
  const { user, setUser } = useContextGlobal()
  const { formRegister, formSubmit, formErrors, InputTextRequired } = useForm()
  const { isFetch, userUpdate } = UserModel()

  const handleSubmit = async (fields: IUSUA) => {
    let body: any = {
      name: fields.name,
      email: fields.email,
    }

    if (fields.password) {
      body = { ...body, password: fields.password }
    }

    const resUpdate = await userUpdate({ body })

    if (resUpdate.status === 201) {
      setUser(resUpdate.data)
    }
  }


  return (
    <>
      <LoadingPage
        isFetch={isFetch}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Configuração', url: '/configuracao' },
          { label: 'Perfil' },
        ]}
      />

      <ContentSection
        title="Dados do Usuário"
        btns={(
          <>
            <button type="submit" className="btn btn-sm" form="formPerfil"><FaSave /></button>
          </>
        )}
      >

        <form id="formPerfil" onSubmit={formSubmit(handleSubmit)}>
          <div className="row gx-2 gy-3">
            <div className="col-12 col-md-4 col-lg-3">
              <Input
                label="Nome"
                placeholder="Digite seu nome"
                type="text"
                disabled={isFetch}
                name="name"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.name}
                defaultValue={String(user.name)}
              />
            </div>

            <div className="col-12 col-md-4 col-lg-3">
              <Input
                label="Email"
                placeholder="Digite seu e-mail"
                type="text"
                disabled={isFetch}
                name="email"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.email}
                defaultValue={String(user.email)}
              />
            </div>

            <div className="col-12 col-md-4 col-lg-3">
              <Input
                label="Password"
                placeholder="Digite uma senha"
                type="text"
                disabled={isFetch}
                name="password"
                register={formRegister}
                error={formErrors.password}
              />
            </div>
          </div>

        </form>
      </ContentSection>

    </>
  )
}
