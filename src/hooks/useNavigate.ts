import { useCallback } from "react";
import { useHistory, useParams, useLocation } from "react-router-dom";

export default function useNavigate() {
  const history = useHistory();
  const urlParams: any = useParams();
  const location: any = useLocation();

  const urlNavigate = useCallback(
    (url: string) => {
      history.push(url);
    },
    [history]
  );

  const urlSearch = useCallback(
    (key: string = "") => {
      let newSearch = new URLSearchParams(location.search);

      if (key) {
        return newSearch.get(key);
      }

      return newSearch;
    },
    [location]
  );

  return {
    urlNavigate,
    urlParams,
    urlSearch
  };
}
