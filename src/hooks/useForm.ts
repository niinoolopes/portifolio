import { useForm as reactHookForm } from "react-hook-form";

export default function useForm() {
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    getValues,
    setValue,
    setError
  } = reactHookForm();

  const InputTextRequired = {
    required: {
      value: true,
      message: "Campo obrigatório"
    }
  };

  const InputSelectRequired = {
    required: {
      value: true,
      message: "Campo obrigatório"
    }
  };

  return {
    formRegister: register,
    formSubmit: handleSubmit,
    formErrors: errors,
    formGetValues: getValues,
    formSetValue: setValue,
    formSetError: setError,
    isSubmitting,
    InputTextRequired,
    InputSelectRequired
  };
}
