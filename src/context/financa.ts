import { useCallback, useState } from "react";
import { formFinancaCarteira } from "../contextData/financa";
import { IFNCG, IFNCT, IFNGP, IFNIS, IFNTP } from "../types/financa";
import { useContextGlobal } from "./global";

type SetCarteiraProps = {
  enable?: 1 | 0;
};
type SetGrupoProps = {
  enable?: 1 | 0;
  fnct_id?: number;
  fntp_id?: number;
};
type SetCategoriaProps = {
  enable?: 1 | 0;
  fnct_id?: number;
  fngp_id?: number;
};

export const useContextFinanca = () => {
  const { login, dataFinanca } = useContextGlobal();

  const [getCarteiraPanel, setCarteiraPanelState] = useState<IFNCT>(() => {
    if (!login) return [];
    return dataFinanca?.carteira.find((item: IFNCT) => item.fnct_panel);
  });
  const [getCarteira, setCarteiraState] = useState<IFNCT[]>(() => {
    if (!login) return [];
    return dataFinanca?.carteira;
  });
  const [getGrupo, setGrupoState] = useState<IFNGP[]>(() => {
    if (!login) return [];
    return dataFinanca?.grupo;
  });
  const [getCategoria, setCategoriaState] = useState<IFNCG[]>(() => {
    if (!login) return [];
    return dataFinanca?.categoria;
  });
  const [getSituacao, setSituacaoState] = useState<IFNIS[]>(() => {
    if (!login) return [];
    return dataFinanca?.situacao;
  });
  const [getTipo, setTipoState] = useState<IFNTP[]>(() => {
    if (!login) return [];
    return dataFinanca?.tipo;
  });

  const setCarteiraPanel = useCallback(() => {
    let carteira: IFNCT = dataFinanca?.carteira
      ? dataFinanca?.carteira.find((item: IFNCT) => item.fnct_panel)
      : formFinancaCarteira;

    setCarteiraPanelState(carteira);

    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [dataFinanca]);

  const setCarteira = useCallback(
    (props: SetCarteiraProps = {}) => {
      const { enable } = props;

      let arr: IFNCT[] = dataFinanca?.carteira || [];

      if (enable)
        arr = arr.filter(
          (item: IFNCT) => Number(item.fnct_enable) === Number(enable)
        );

      setCarteiraState(arr);

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [dataFinanca]
  );

  const setGrupo = useCallback(
    async (props: SetGrupoProps = {}) => {
      const { enable, fnct_id, fntp_id } = props;

      let arr: IFNGP[] = dataFinanca?.grupo || [];

      if (enable)
        arr = arr.filter(
          (item: IFNGP) => Number(item.fngp_enable) === Number(enable)
        );
      if (fnct_id) arr = arr.filter((item: IFNGP) => item.fnct_id === fnct_id);
      if (fntp_id) arr = arr.filter((item: IFNGP) => item.fntp_id === fntp_id);

      setGrupoState(arr);
      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [dataFinanca]
  );

  const setCategoria = useCallback(
    async (props: SetCategoriaProps = {}) => {
      const { enable, fnct_id, fngp_id } = props;

      let arr: IFNCG[] = dataFinanca?.categoria || [];

      if (enable)
        arr = arr.filter(
          (item: IFNCG) => Number(item.fncg_enable) === Number(enable)
        );
      if (fnct_id) arr = arr.filter((item: IFNCG) => item.fnct_id === fnct_id);
      if (fngp_id) arr = arr.filter((item: IFNCG) => item.fngp_id === fngp_id);

      setCategoriaState(arr);

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [dataFinanca]
  );

  const setSituacao = useCallback(() => {
    let arr: IFNIS[] = dataFinanca?.situacao || [];

    setSituacaoState(arr);

    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [dataFinanca]);

  const setTipo = useCallback(() => {
    let arr: IFNTP[] = dataFinanca?.Tipo || [];

    setTipoState(arr);

    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [dataFinanca]);

  return {
    getCarteiraPanel,
    setCarteiraPanel,
    getCarteira,
    setCarteira,
    getGrupo,
    setGrupo,
    getCategoria,
    setCategoria,
    getSituacao,
    setSituacao,
    getTipo,
    setTipo
  };
};
