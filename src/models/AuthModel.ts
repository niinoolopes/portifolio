import { useCallback, useState } from "react";
import { useContextGlobal } from "../context/global";
import useApi, { messages } from "../hooks/useApi";
import { IGetTokenProps, ISignInProps } from "../types/request";
import { baseMethodGet, baseMethodStrore } from "../utils/models/baseMethods";

export default function AuthModel() {
  const { showAlert } = useContextGlobal();
  const [isFetch, setIsFetch] = useState(false);
  const { request } = useApi();

  const getToken = useCallback(
    async (props: IGetTokenProps) => {
      return await baseMethodStrore({
        url: `login`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.auth.token.sucess,
        msgError: messages.auth.token.error,
        showAlert,
        body: props.body,
        p: false
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const signIn = useCallback(
    async (props: ISignInProps) => {
      return await baseMethodGet({
        url: `user/full-data`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.auth.signIn.sucess,
        msgError: messages.auth.signIn.error,
        showAlert,
        headers: props.headers,
        p: false
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  return {
    isFetch,
    getToken,
    signIn
  };
}
