/**
 * @auther zibo
 * @date 2022/8/11
 */
const { stringToU8a, u8aToHex } = require('@polkadot/util');
const { Keyring } = require('@polkadot/keyring');
const { ApiPromise, WsProvider } = require("@polkadot/api");
const { typesBundleForPolkadot } = require("@crustio/type-definitions");

async function sign() {
    const seed = Buffer.from(process.env.AUTH_SEED_BASE64, 'base64').toString()
    const api = new ApiPromise({
        provider: new WsProvider('wss://rpc.crust.network'),
        typesBundle: typesBundleForPolkadot,
    });
    await api.isReady;
    const keyring = new Keyring({ type: 'sr25519' });
    const pair = keyring.createFromUri(seed);
    keyring.setSS58Format(66);
    const signature = Buffer.from(`substrate-${pair.address}:${u8aToHex(pair.sign(pair.address))}`);
    console.log(`signature: ${signature.toString('base64')}`);
}

sign()
