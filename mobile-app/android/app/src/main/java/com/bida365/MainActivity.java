package com.bida365;

import com.facebook.react.ReactActivity;
import com.sbugert.rnadmob.RNAdMobPackage;
import com.brentvatne.react.ReactVideoPackage;
import com.oblador.vectoricons.VectorIconsPackage;
import com.geektime.reactnativeonesignal.ReactNativeOneSignalPackage;

import android.content.Intent;
import android.os.Bundle;

public class MainActivity extends ReactActivity {

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
    }

    /**
     * Returns the name of the main component registered from JavaScript.
     * This is used to schedule rendering of the component.
     */
    @Override
    protected String getMainComponentName() {
        return "bida365";
    }
}
