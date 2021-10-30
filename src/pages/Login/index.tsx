import { useEffect, useRef } from "react"
import { FaSignInAlt } from "react-icons/fa"
import Input from "../../components/form/Input"
import { useContextGlobal } from "../../context/global"
import useForm from "../../hooks/useForm"
import useNavigate from "../../hooks/useNavigate"
import AuthModel from "../../models/AuthModel"
import { IUSUA } from "../../types/global"

export default function Login() {
  const isMounted = useRef(true)
  const { urlNavigate } = useNavigate()
  const { signOut: signOutStore, signIn: signInStore } = useContextGlobal()
  const { formRegister, formSubmit, formErrors, InputTextRequired } = useForm()
  const { isFetch, getToken, signIn } = AuthModel()

  const handleSubmit = async (body: IUSUA) => {

    // // TOKEN
    const resToken = await getToken({
      body: {
        email: body.email,
        password: body.password || '',
      }
    })

    if (!resToken.status) {
      return
    }

    // // SIGNIN
    const { token } = resToken.data

    const resSignIn = await signIn({ headers: { Authorization: `Bearer ${token}` } })

    if (!resSignIn.status) {
      return
    }

    const { PERIODO, FINANCA, USUARIO } = resSignIn.data

    signInStore({
      PERIODO: PERIODO,
      FINANCA,
      TOKEN: token,
      USUARIO
    })

    urlNavigate('dashboard')
  }

  useEffect(() => {
    if (isMounted.current) {
      signOutStore()
    }

    return () => { isMounted.current = false };
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  return (
    <div className="m-auto col-md-8 h-100 d-flex">
      <section className="m-auto col-11 col-md-9 col-lg-7 border p-3 shadow-sm">
        <h1 className="display-5">Bem vindo!</h1>

        <hr />

        <form onSubmit={formSubmit(handleSubmit)} className='needs-validation'>
          <div className="row g-2">

            <div className="col-12 col-md-6">
              <Input
                label="E-mail"
                placeholder="Digite seu e-mail"
                type="email"
                disabled={isFetch}
                name="email"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.email}
                defaultValue={process.env.NODE_ENV === "development" ? "niinoolopes0@gmail.com" : ''}
              />
            </div>

            <div className="col-12 col-md-6">
              <Input
                label="Senha"
                placeholder="Digite seu e-mail"
                type="password"
                disabled={isFetch}
                name="password"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.password}
                defaultValue={process.env.NODE_ENV === "development" ? "123" : ''}
              />
            </div>

            <div className="col-12 mt-3">
              <button type="submit" disabled={isFetch} className="btn btn-sm btn-outline-secondary shadow-none d-flex justify-content-center">
                {isFetch
                  ? <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  : <FaSignInAlt size="18" />
                }
              </button>
            </div>
          </div>
        </form>
      </section>
    </div>
  )
}
