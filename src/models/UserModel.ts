import { useCallback, useState } from "react";
import { useContextGlobal } from "../context/global";
import useApi, { messages } from "../hooks/useApi";
import { IUserUpdate } from "../types/request";
import { baseMethodUpdate } from "../utils/models/baseMethods";

export default function UserModel() {
  const { showAlert } = useContextGlobal();
  const [isFetch, setIsFetch] = useState(false);
  const { request } = useApi();

  const userUpdate = useCallback(async (props: IUserUpdate) => {
    return await baseMethodUpdate({
      url: `user`,
      setFetch: setIsFetch,
      request,
      msgSuccess: messages.user.update.sucess,
      msgError: messages.user.update.error,
      showAlert,
      body: props.body
    });

    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, []);

  return {
    isFetch,
    userUpdate
  };
}
