export interface IData {
  data:IState
}

export interface IState {
  characters: ICharacter[];
  info: Iinfo[];
  loading: boolean;
  species: string[];
  errorInSearch:boolean;
}

export interface Iinfo {
  count: number;
  pages: number;
  next: string;
  prev: string;
}
export interface ICharacter {
  id: number;
  name: string;
  status: string;
  species: string;
  type: string;
  gender: string;
  origin: {
    name: string;
    url: string;
  };
  location: {
    name: string;
    url: string;
  };
  image: string;
  episode: string[];
  url: string;
  created: string;
}
