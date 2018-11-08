import _ from 'lodash';

export const getReadableStreamResponse =  (readableStream, toString = true) => {
  const reader = readableStream.getReader();
  let chunks = new Uint8Array([]);

  function mergeUintArrays(arr1, arr2) {
    const arr = new Uint8Array(arr1.length + arr2.length);
    arr.set(arr1);
    arr.set(arr2, arr1.length);
    return arr;
  }

  function readStream() {
    return reader.read().then(({ value, done }) => {
      if (done) {
        return toString ? new TextDecoder('utf-8').decode(chunks) : chunks;
      }

      chunks = mergeUintArrays(chunks, value);

      return readStream();
    });
  }

  return readStream();
};

export const getQueryParameters = (url) => {
  return _.chain(url)
    .split('?')
    .compact()
    .last()
    .split('&')
    .compact()
    .map(pair => _.split(pair, '=', '2'))
    .fromPairs()
    .value();
};

export const getPageFromInfo = (info, page = 'next') => {
  return _.chain(info)
    .pick(`${page}`)
    .mapValues(value => _.get(getQueryParameters(value), 'page'))
    .values()
    .first()
    .toInteger()
    .value();
};


export const getPaginationFromInfo = info => {
  const next = getPageFromInfo(info);
  const prev = getPageFromInfo(info, 'prev');

  const current = next > 0 ? next - 1 : prev + 1;

 return {next, prev, current};
};

export const getSearchString = searchParams => {
  const search = _.chain(searchParams)
    .pickBy(value => !_.isEmpty(`${value}`))
    .toPairs()
    .map(pair => pair.join('='))
    .join('&')
    .value();
  return search ? `?${search}` : '';
};