import React, { useContext, createContext, useState, useCallback } from "react";
import { IALERT, IUSUA } from "../types/global";
import { IFinanca, IFNCT } from "../types/financa";

export const Context = createContext(null);

type IProps = {
  children: any;
};

export const StorageGlobal = (props: IProps) => {
  const [loading, setLoading] = useState<boolean>(false);

  // uso geral
  const [alert, setAlert] = useState<IALERT>({ enable: false, title: "", messages: [] });
  const [login, setLogin] = useState<boolean>(false);
  const [token, setToken] = useState<string>("");

  // controle dos modais
  // const [modalCarteira, setModalCarteira] = useState(false);
  const [modalCofre, setModalCofre] = useState(false);
  const [modalFinanca, setModalFinanca] = useState(false);
  const [modalInvestimento, setModalInvestimento] = useState(false);

  const [dataPage, setDataPage] = useState({
    formSearch: {},
    form: {},
    items: [],
    pagination: {},
  });

  // data para cada modulo
  const [user, setUser] = useState<IUSUA>();
  const [periodo, setPeriodo] = useState<string>("");
  const [dataFinanca, setDataFinanca] = useState<IFinanca>({ panel: 0 });
  // const [dataCofre, setDataCofre] = useState<ICofre>({ panel: 0 });
  // const [dataInvestimento, setDataInvestimento] = useState<IInvestimento>({ panel: 0 });


  // LOGIN
  const signIn = useCallback(
    ({ PERIODO, TOKEN, USUARIO, FINANCA }) => {
      let filter: any = null

      setLogin(true);
      setToken(TOKEN);
      setPeriodo(PERIODO);
      setUser(USUARIO);

      // FINANCA
      filter = FINANCA.carteira.filter((el: IFNCT) => el.fnct_panel);
      let fnct_panel: IFNCT = filter.length ? filter[0].fnct_id : 0
      // SET FINANCA
      setDataFinanca({
        panel: Number(fnct_panel),
        carteira: FINANCA.carteira,
        grupo: FINANCA.grupo,
        categoria: FINANCA.categoria,
        situacao: FINANCA.situacao,
        tipo: FINANCA.tipo
      })


      // COFRE
      // filter = COFRE.carteira.filter((el: ICOCT) => el.coct_panel);
      // let coct_panel: ICOCT = filter.length ? filter[0].coct_id : 0

      // setDataCofre({
      //   panel: Number(coct_panel),
      //   carteira: COFRE.carteira,
      //   tipo: COFRE.tipo,
      // });


      // INVESTIMENTO
      // filter = INVESTIMENTO.carteira.filter((el: IINCT) => el.inct_panel);
      // let inct_panel: IINCT = filter.length ? filter[0].inct_id : 0

      // setDataInvestimento({
      //   panel: Number(inct_panel),
      //   carteira: INVESTIMENTO.carteira,
      //   ativo: INVESTIMENTO.ativo,
      //   ativoTipo: INVESTIMENTO.ativoTipo,
      //   tipo: INVESTIMENTO.tipo,
      //   corretora: INVESTIMENTO.corretora,
      // });
    },
    []
  );
  const signOut = useCallback(() => {
    // setModalCarteira(false);
    setModalCofre(false);
    setModalFinanca(false);
    setModalInvestimento(false);
    setUser({ id: "", name: "", email: "" });
    setToken("");
    setLogin(false);
    //}, [setModalCarteira, setModalCofre, setModalFinanca, setModalInvestimento, setUser, setToken, setLogin]);
  }, []);


  // ALERT
  const showAlert = useCallback((newType, newMessages) => {
    setAlert(data => {
      return {
        ...data,
        enable: true,
        type: newType === 'ok' ? 'success' : "danger",
        messages: [...data.messages, ...newMessages]
      }
    });
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, []);
  const hideAlert = useCallback(() => {
    setAlert({ enable: false, messages: [] });
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, []);


  const storage: any = {
    loading, setLoading,

    login, setLogin, signIn, signOut,
    token, setToken,
    alert, setAlert, showAlert, hideAlert,
    periodo, setPeriodo,

    user, setUser,

    // modalCarteira, toggleModalCarteira,
    modalCofre, setModalCofre,
    modalFinanca, setModalFinanca,
    modalInvestimento, setModalInvestimento,
    dataPage, setDataPage,
    dataFinanca, setDataFinanca,
    // dataCofre, setDataCofre,
    // dataInvestimento, setDataInvestimento,
  };

  return (
    <Context.Provider value={storage}>
      {props.children}
    </Context.Provider>
  )
};

export const useContextGlobal = () => {
  return useContext<any>(Context);
};
